<?php

namespace App\Jobs;

use App\Models\ResultadoMesa;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcesarReporteMesa implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        private int $mesaId,
        private ?int $testigoId,
        private array $imagenesTempPaths,  // rutas en disco local (actas_temp/uuid.ext)
        private array $imagenesEliminar,   // rutas en disco public a borrar
    ) {}

    public function handle(): void
    {
        if (empty($this->imagenesTempPaths) && empty($this->imagenesEliminar)) {
            return;
        }

        $resultado = ResultadoMesa::where('mesa_id', $this->mesaId)->first();
        if (!$resultado) {
            return;
        }

        // Eliminar imágenes que el usuario quitó
        foreach ($this->imagenesEliminar as $imgVieja) {
            if ($imgVieja && Storage::disk('public')->exists($imgVieja)) {
                Storage::disk('public')->delete($imgVieja);
            }
        }

        // Mover nuevas imágenes de temp a public
        $nuevasRutas = [];
        foreach ($this->imagenesTempPaths as $tempPath) {
            if ($tempPath && Storage::disk('local')->exists($tempPath)) {
                $contenido = Storage::disk('local')->get($tempPath);
                $destino   = 'actas/' . basename($tempPath);
                Storage::disk('public')->put($destino, $contenido);
                Storage::disk('local')->delete($tempPath);
                $nuevasRutas[] = $destino;
            }
        }

        if (!empty($nuevasRutas)) {
            $imagenesActuales = $resultado->imagen_acta ?? [];
            $resultado->imagen_acta = array_merge($imagenesActuales, $nuevasRutas);
            $resultado->save();
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Error procesando reporte de mesa', [
            'mesa_id' => $this->mesaId,
            'error'   => $exception->getMessage(),
        ]);

        // Limpiar archivos temp huérfanos
        foreach ($this->imagenesTempPaths as $tempPath) {
            if ($tempPath && Storage::disk('local')->exists($tempPath)) {
                Storage::disk('local')->delete($tempPath);
            }
        }
    }
}

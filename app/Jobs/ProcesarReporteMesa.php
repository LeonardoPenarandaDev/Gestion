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
    public int $timeout = 60;

    public function __construct(
        private int $mesaId,
        private int $testigoId,
        private string $observacion,
        private ?int $totalVotos,
        private ?int $votosCompetencia,
        private ?string $imagenTempPath,
        private ?string $imagenAnterior,
    ) {}

    public function handle(): void
    {
        // El job solo procesa la imagen — los datos ya fueron guardados síncronamente
        if (!$this->imagenTempPath) {
            return;
        }

        $resultado = ResultadoMesa::where('mesa_id', $this->mesaId)->first();
        if (!$resultado) {
            return;
        }

        // Eliminar imagen anterior si existe
        if ($this->imagenAnterior && Storage::disk('public')->exists($this->imagenAnterior)) {
            Storage::disk('public')->delete($this->imagenAnterior);
        }

        // Mover imagen de temp a destino final
        if (Storage::disk('local')->exists($this->imagenTempPath)) {
            $contenido = Storage::disk('local')->get($this->imagenTempPath);
            $destino   = 'actas/' . basename($this->imagenTempPath);
            Storage::disk('public')->put($destino, $contenido);
            Storage::disk('local')->delete($this->imagenTempPath);
            $resultado->imagen_acta = $destino;
            $resultado->save();
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Error procesando reporte de mesa', [
            'mesa_id'   => $this->mesaId,
            'error'     => $exception->getMessage(),
        ]);

        // Limpiar imagen temp si quedó huérfana
        if ($this->imagenTempPath && Storage::disk('local')->exists($this->imagenTempPath)) {
            Storage::disk('local')->delete($this->imagenTempPath);
        }
    }
}
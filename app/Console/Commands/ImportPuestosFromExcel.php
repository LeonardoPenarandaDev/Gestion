<?php

namespace App\Console\Commands;

use App\Models\Puesto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportPuestosFromExcel extends Command
{
    protected $signature = 'puestos:import {file? : Ruta al archivo Excel}';

    protected $description = 'Importa puestos de votación desde un archivo Excel';

    public function handle()
    {
        $file = $this->argument('file') ?? storage_path('Divipole.xlsx');

        if (!file_exists($file)) {
            $this->error("El archivo no existe: $file");
            return 1;
        }

        $this->info("Leyendo archivo: $file");

        try {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            $this->info("Total de filas encontradas: " . ($highestRow - 1));

            if (!$this->confirm('¿Deseas eliminar los puestos actuales antes de importar?', true)) {
                $this->info('Importación cancelada.');
                return 0;
            }

            // Verificar si hay testigos asociados a puestos
            $testigosCount = DB::table('testigo')->count();
            if ($testigosCount > 0) {
                $this->warn("Hay $testigosCount testigos asociados a puestos.");
                if (!$this->confirm('¿Deseas continuar? Los testigos perderán su asociación con puestos.', false)) {
                    $this->info('Importación cancelada.');
                    return 0;
                }
                // Limpiar referencias de testigos
                DB::table('testigo')->update(['fk_id_puesto' => null]);
            }

            // Desactivar restricciones de FK temporalmente
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Eliminar mesas existentes
            DB::table('mesas')->truncate();
            $this->info('Mesas eliminadas.');

            // Eliminar puestos existentes
            $deletedCount = Puesto::count();
            DB::table('puesto')->truncate();
            $this->info("Se eliminaron $deletedCount puestos existentes.");

            // Reactivar restricciones de FK
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // Importar nuevos puestos
            $imported = 0;
            $errors = [];
            $bar = $this->output->createProgressBar($highestRow - 1);
            $bar->start();

            for ($row = 2; $row <= $highestRow; $row++) {
                $munCodigo = trim($sheet->getCell('A' . $row)->getValue() ?? '');
                $zona = trim($sheet->getCell('B' . $row)->getValue() ?? '');
                $puesto = trim($sheet->getCell('C' . $row)->getValue() ?? '');
                $munNombre = trim($sheet->getCell('D' . $row)->getValue() ?? '');
                $nombre = trim($sheet->getCell('E' . $row)->getValue() ?? '');
                $mesas = (int)($sheet->getCell('F' . $row)->getValue() ?? 0);
                $direccion = trim($sheet->getCell('G' . $row)->getValue() ?? '');

                // Validar que los campos requeridos no estén vacíos (permite 0 como valor válido)
                if ($munCodigo === '' || $zona === '' || $puesto === '' || empty($nombre)) {
                    $errors[] = "Fila $row: Datos incompletos";
                    $bar->advance();
                    continue;
                }

                // Formatear zona y puesto a 2 dígitos
                $zona = str_pad($zona, 2, '0', STR_PAD_LEFT);
                $puesto = str_pad($puesto, 2, '0', STR_PAD_LEFT);

                try {
                    Puesto::create([
                        'municipio_codigo' => $munCodigo,
                        'municipio_nombre' => $munNombre,
                        'zona' => $zona,
                        'puesto' => $puesto,
                        'nombre' => $nombre,
                        'direccion' => $direccion,
                        'total_mesas' => $mesas,
                        'alias' => null,
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Fila $row: " . $e->getMessage();
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);

            $this->info("Importación completada:");
            $this->info("  - Puestos importados: $imported");

            if (count($errors) > 0) {
                $this->warn("  - Errores: " . count($errors));
                if ($this->confirm('¿Deseas ver los errores?', false)) {
                    foreach ($errors as $error) {
                        $this->error("  $error");
                    }
                }
            }

            // Mostrar resumen por municipio
            $this->newLine();
            $this->info("Resumen por municipio:");
            $resumen = Puesto::selectRaw('municipio_codigo, municipio_nombre, COUNT(*) as puestos, SUM(total_mesas) as mesas')
                ->groupBy('municipio_codigo', 'municipio_nombre')
                ->orderBy('municipio_codigo')
                ->get();

            $this->table(
                ['Código', 'Municipio', 'Puestos', 'Mesas'],
                $resumen->map(fn($r) => [$r->municipio_codigo, $r->municipio_nombre, $r->puestos, $r->mesas])
            );

            return 0;

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}

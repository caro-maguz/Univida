<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TiposRecursoSeeder extends Seeder
{
    public function run()
    {
        // Verificar que la tabla existe
        if (!Schema::hasTable('tipos_recurso')) {
            $this->command->warn('La tabla tipos_recurso no existe.');
            return;
        }

        $tipos = [
            [
                'nombre' => 'Protocolo',
                'descripcion' => 'Protocolos de atención y actuación',
            ],
            [
                'nombre' => 'Emergencias',
                'descripcion' => 'Contactos y recursos de emergencia',
            ],
            [
                'nombre' => 'Material Educativo',
                'descripcion' => 'Material educativo y de prevención',
            ],
            [
                'nombre' => 'Prevención',
                'descripcion' => 'Recursos para prevención',
            ],
            [
                'nombre' => 'Acompañamiento',
                'descripcion' => 'Guías de acompañamiento y apoyo',
            ],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipos_recurso')->updateOrInsert(
                ['nombre' => $tipo['nombre']],
                $tipo
            );
        }

        $this->command->info('✅ Tipos de recurso insertados correctamente.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TipoViolenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Si la tabla no existe, no intentar insertar para evitar errores.
        if (!Schema::hasTable('tipo_violencia')) {
            $this->command->info("La tabla 'tipo_violencia' no existe. Ejecuta la migración primero.");
            return;
        }

        $tipos = [
            ['nombre' => 'Psicológica', 'descripcion' => 'Violencia que afecta la salud mental y emocional.'],
            ['nombre' => 'Sexual',     'descripcion' => 'Violencia de naturaleza sexual.'],
            ['nombre' => 'Económica',  'descripcion' => 'Restricción o control de recursos económicos.'],
            ['nombre' => 'Emocional',  'descripcion' => 'Abuso que genera daño emocional o humillación.'],
            ['nombre' => 'Física',     'descripcion' => 'Agresiones físicas o daño corporal.'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipo_violencia')->updateOrInsert(
                ['nombre' => $tipo['nombre']],
                ['descripcion' => $tipo['descripcion']]
            );
        }

        $this->command->info('Seeder TipoViolencia ejecutado: tipos insertados/actualizados.');
    }
}

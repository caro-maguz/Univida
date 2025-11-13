<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntaTestSeeder extends Seeder
{
    /**
     * Seed de preguntas mejorado para el test de evaluación emocional
     * Incluye preguntas específicas para cada tipo de violencia en la BD:
     * - Violencia Psicológica
     * - Violencia Sexual
     * - Violencia Económica
     * - Violencia Emocional
     * - Violencia Física
     */
    public function run()
    {
        // Limpiar preguntas existentes (desactivar foreign keys temporalmente)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('respuesta_test')->truncate();
        DB::table('pregunta_test')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Banco de preguntas organizadas por tipo de violencia
        // FORMATO: Sí/No con peso para cada pregunta
        $preguntas = [
            // ========================================
            // VIOLENCIA PSICOLÓGICA (4 preguntas)
            // ========================================
            [
                'enunciado' => '¿Alguien en tu entorno te insulta, humilla o ridiculiza constantemente?',
                'categoria' => 'Psicológica'
            ],
            [
                'enunciado' => '¿Has recibido comentarios que te hacen sentir inferior, incapaz o sin valor?',
                'categoria' => 'Psicológica'
            ],
            [
                'enunciado' => '¿Has sido amenazado/a o intimidado/a por alguien cercano?',
                'categoria' => 'Psicológica'
            ],
            [
                'enunciado' => '¿Te hacen sentir culpable por cosas que no son tu responsabilidad?',
                'categoria' => 'Psicológica'
            ],

            // ========================================
            // VIOLENCIA EMOCIONAL (4 preguntas)
            // ========================================
            [
                'enunciado' => '¿Te han alejado de tus amigos, familia o personas importantes para ti?',
                'categoria' => 'Emocional'
            ],
            [
                'enunciado' => '¿Alguien controla excesivamente tus actividades, decisiones o forma de vestir?',
                'categoria' => 'Emocional'
            ],
            [
                'enunciado' => '¿Invaden tu privacidad revisando tus pertenencias, mensajes o redes sociales sin permiso?',
                'categoria' => 'Emocional'
            ],
            [
                'enunciado' => '¿Sientes miedo constante de expresar tus opiniones o hacer enojar a alguien?',
                'categoria' => 'Emocional'
            ],

            // ========================================
            // VIOLENCIA FÍSICA (4 preguntas)
            // ========================================
            [
                'enunciado' => '¿Has recibido empujones, jalones, sacudidas o agarrones violentos?',
                'categoria' => 'Física'
            ],
            [
                'enunciado' => '¿Has sido golpeado/a, abofeteado/a o agredido/a físicamente?',
                'categoria' => 'Física'
            ],
            [
                'enunciado' => '¿Han destruido o lanzado objetos cerca de ti para intimidarte?',
                'categoria' => 'Física'
            ],
            [
                'enunciado' => '¿Te han impedido salir, te han encerrado o bloqueado el paso físicamente?',
                'categoria' => 'Física'
            ],

            // ========================================
            // VIOLENCIA SEXUAL (4 preguntas)
            // ========================================
            [
                'enunciado' => '¿Has sido presionado/a u obligado/a a realizar actos sexuales contra tu voluntad?',
                'categoria' => 'Sexual'
            ],
            [
                'enunciado' => '¿Has experimentado tocamientos o acercamientos sexuales no deseados?',
                'categoria' => 'Sexual'
            ],
            [
                'enunciado' => '¿Han ignorado tu negativa o te han hecho sentir culpable por no acceder a demandas sexuales?',
                'categoria' => 'Sexual'
            ],
            [
                'enunciado' => '¿Has recibido comentarios ofensivos, humillantes o acoso de índole sexual?',
                'categoria' => 'Sexual'
            ],

            // ========================================
            // VIOLENCIA ECONÓMICA (4 preguntas)
            // ========================================
            [
                'enunciado' => '¿Alguien controla completamente tus recursos económicos o te exige rendir cuentas de cada gasto?',
                'categoria' => 'Económica'
            ],
            [
                'enunciado' => '¿Te impiden trabajar, estudiar o desarrollarte profesionalmente?',
                'categoria' => 'Económica'
            ],
            [
                'enunciado' => '¿Han tomado o usado tu dinero, tarjetas o propiedades sin tu autorización?',
                'categoria' => 'Económica'
            ],
            [
                'enunciado' => '¿Te niegan recursos para cubrir necesidades básicas como alimentación, salud o educación?',
                'categoria' => 'Económica'
            ],
        ];

        // Insertar preguntas en la base de datos
        foreach ($preguntas as $pregunta) {
            DB::table('pregunta_test')->insert([
                'enunciado' => $pregunta['enunciado'],
                'fk_test' => null, // Las preguntas son genéricas, no pertenecen a un test específico
            ]);
        }

        // Mostrar resumen
        echo "\n✅ Se han insertado " . count($preguntas) . " preguntas en el test\n";
        echo "📊 Distribución por tipo:\n";
        echo "   - Violencia Psicológica: 4 preguntas\n";
        echo "   - Violencia Emocional: 4 preguntas\n";
        echo "   - Violencia Física: 4 preguntas\n";
        echo "   - Violencia Sexual: 4 preguntas\n";
        echo "   - Violencia Económica: 4 preguntas\n";
        echo "   TOTAL: 20 preguntas (Sí/No)\n\n";
    }
}

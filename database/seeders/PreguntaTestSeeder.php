<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntaTestSeeder extends Seeder
{
    public function run()
    {
        // Borrar datos sin TRUNCATE (respeta las FK)
        DB::table('respuesta_test')->delete();
        DB::table('pregunta_test')->delete();

        // Nuevas preguntas
        $preguntas = [
            ['id_pregunta' => 1,  'enunciado' => '¿Has sentido incomodidad o miedo hacia alguna persona dentro del entorno universitario?'],
            ['id_pregunta' => 2,  'enunciado' => '¿Alguien te ha hecho comentarios sobre tu cuerpo, apariencia o vida personal que te resultaron incómodos?'],
            ['id_pregunta' => 3,  'enunciado' => '¿Has recibido mensajes, llamadas o contactos insistentes que no deseas?'],
            ['id_pregunta' => 4,  'enunciado' => '¿Alguien ha invadido tu espacio personal sin tu consentimiento?'],

            ['id_pregunta' => 5,  'enunciado' => '¿Has sido objeto de insultos, burlas o humillaciones relacionadas con tu género?'],
            ['id_pregunta' => 6,  'enunciado' => '¿Alguien ha intentado controlarte (amistades, forma de vestir, actividades)?'],
            ['id_pregunta' => 7,  'enunciado' => '¿Has sido amenazado/a directa o indirectamente?'],

            ['id_pregunta' => 8,  'enunciado' => '¿Has sido empujado/a, golpeado/a o agredido/a físicamente?'],
            ['id_pregunta' => 9,  'enunciado' => '¿Alguien ha intentado dañarte físicamente dentro o fuera de la universidad?'],

            ['id_pregunta' => 10, 'enunciado' => '¿Has recibido insinuaciones sexuales no deseadas?'],
            ['id_pregunta' => 11, 'enunciado' => '¿Alguien ha tocado tu cuerpo sin tu consentimiento?'],
            ['id_pregunta' => 12, 'enunciado' => '¿Te has sentido presionado/a para realizar actos sexuales?'],

            ['id_pregunta' => 13, 'enunciado' => '¿Has recibido mensajes ofensivos o amenazas por redes sociales o medios digitales?'],
            ['id_pregunta' => 14, 'enunciado' => '¿Han difundido información personal, fotos o videos tuyos sin autorización?'],

            ['id_pregunta' => 15, 'enunciado' => '¿La persona involucrada pertenece a la comunidad universitaria (estudiante, docente o administrativo)?'],
            ['id_pregunta' => 16, 'enunciado' => '¿Los hechos ocurrieron dentro de instalaciones universitarias o en actividades institucionales?'],

            ['id_pregunta' => 17, 'enunciado' => '¿Has informado previamente esta situación a algún canal institucional?'],
            ['id_pregunta' => 18, 'enunciado' => '¿Deseas recibir orientación o apoyo institucional?'],
            ['id_pregunta' => 19, 'enunciado' => '¿Te sientes en riesgo actualmente?'],
        ];

        DB::table('pregunta_test')->insert($preguntas);

        echo "\n✅ Insertadas " . count($preguntas) . " preguntas correctamente.\n";
    }
}

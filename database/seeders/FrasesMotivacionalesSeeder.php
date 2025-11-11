<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrasesMotivacionalesSeeder extends Seeder
{
    public function run(): void
    {
        $frases = [
            'Ninguna forma de violencia es normal. Mereces respeto, siempre.',
            'Lo que te incomoda también importa. Escucha tu voz.',
            'Callar no te protege; hablar puede cambiarlo todo.',
            'Nombrar lo que duele es el primer paso para sanar.',
            'Tu historia merece ser escuchada, sin miedo ni juicio.',
            'Reconocer la violencia no te hace débil, te hace consciente.',
            'Si algo no te hace sentir seguro(a), no lo ignores. Confía en tu intuición.',
            'No estás exagerando si algo te duele o te incomoda.',
            'La violencia no tiene justificación, ni dentro ni fuera de la universidad.',
            'La valentía también se ve en quien pide ayuda.',
            'Nadie debería enfrentar la violencia solo(a); pedir apoyo también es autocuidado.',
            'Escuchar con empatía puede cambiar el día de alguien.',
            'En una comunidad que se cuida, la violencia no tiene lugar.',
            'Ser testigo y no callar también es un acto de valentía.',
            'Cuando apoyas a alguien que atraviesa una situación difícil, también siembras esperanza.',
            'Cada palabra de apoyo puede ser un refugio.',
            'A veces, lo más valiente que puedes hacer es acompañar en silencio y sin juzgar.',
            'La universidad es más fuerte cuando nos cuidamos entre todos.',
            'No necesitas entenderlo todo para ser un apoyo; solo estar presente.',
            'Construir espacios seguros empieza con pequeños gestos de respeto.',
        ];

        foreach ($frases as $texto) {
            DB::table('frases_motivacionales')->updateOrInsert(
                ['texto' => $texto],
                ['activo' => true, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreguntaTest;
use App\Models\RespuestaTest;
use App\Models\Test;
use Carbon\Carbon;

class TestController extends Controller
{
    /**
     * Mostrar el formulario del test
     */
    public function mostrar()
    {
        // Verificar que el usuario esté autenticado
        if (!session('rol') || session('rol') !== 'usuario') {
            return redirect()->route('login.user')->with('error', 'Debes iniciar sesión como usuario');
        }

        // Obtener todas las preguntas del test
        $preguntas = PreguntaTest::all();

        if ($preguntas->isEmpty()) {
            return redirect()->route('inicio.usuario')
                ->with('error', 'No hay preguntas disponibles en este momento.');
        }

        return view('test.realizar', compact('preguntas'));
    }

    /**
     * Procesar las respuestas del test y calcular resultado
     */
    public function procesar(Request $request)
    {
        // Verificar autenticación
        if (!session('rol') || session('rol') !== 'usuario') {
            return redirect()->route('login.user')->with('error', 'Debes iniciar sesión como usuario');
        }

        // Validar que se hayan respondido todas las preguntas
        $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*' => 'required|in:si,no', // Respuestas Sí/No
        ], [
            'respuestas.required' => 'Debes responder todas las preguntas.',
            'respuestas.*.required' => 'Todas las preguntas son obligatorias.',
        ]);

        $respuestas = $request->input('respuestas');
        $usuarioId = session('id');

        // Obtener las preguntas para análisis detallado
        $preguntas = PreguntaTest::whereIn('id_pregunta', array_keys($respuestas))->get();
        
        // Calcular puntuación: contar respuestas "Sí" (señales de alerta)
        $respuestasSi = 0;
        $cantidadPreguntas = count($respuestas);

        foreach ($respuestas as $preguntaId => $valor) {
            if ($valor === 'si') {
                $respuestasSi++;
            }
        }

        // Calcular porcentaje de señales de alerta
        $porcentajeAlerta = ($respuestasSi / $cantidadPreguntas) * 100;

        // Determinar resultado basado en porcentaje de respuestas Sí
        if ($porcentajeAlerta >= 60) {
            // 60% o más respuestas "Sí"
            $resultado = 'Riesgo Crítico';
            $mensaje = '⚠️ Detectamos múltiples señales de alerta muy importantes. Tu seguridad y bienestar están en riesgo. Es fundamental que busques ayuda profesional inmediatamente.';
            $color = 'danger';
            $recomendaciones = [
                'Tu seguridad es prioritaria. Considera buscar ayuda profesional inmediata.',
                'Contacta con servicios de atención a víctimas de violencia de género.',
                'Si estás en peligro inmediato, llama a emergencias (123) o policía (112).',
                'Habla con personas de confianza sobre tu situación.',
                'Elabora un plan de seguridad si necesitas salir de esta situación.'
            ];
        } elseif ($porcentajeAlerta >= 30) {
            // 30-59% respuestas "Sí"
            $resultado = 'Riesgo Alto';
            $mensaje = '🔴 Se identifican señales significativas de preocupación que merecen atención urgente.';
            $color = 'danger';
            $recomendaciones = [
                'Es importante hablar con alguien de confianza sobre lo que estás experimentando.',
                'Considera buscar orientación profesional o asesoría.',
                'Reflexiona sobre los patrones en tus relaciones y cómo te hacen sentir.',
                'Conoce tus derechos y recursos disponibles en tu comunidad.',
                'No estás sola/o, existen servicios de apoyo gratuitos y confidenciales.'
            ];
        } elseif ($porcentajeAlerta >= 15) {
            // 15-29% respuestas "Sí"
            $resultado = 'Riesgo Moderado';
            $mensaje = '🟡 Detectamos algunas señales de alerta. Es importante que prestes atención y consideres buscar orientación.';
            $color = 'warning';
            $recomendaciones = [
                'Habla sobre tus preocupaciones con personas de confianza.',
                'Utiliza nuestro chat de apoyo para recibir orientación.',
                'Reflexiona sobre los límites saludables en tus relaciones.',
                'Mantente informado/a sobre relaciones sanas vs. no saludables.',
                'Considera realizar seguimiento con otro test en el futuro.'
            ];
        } else {
            // Menos del 15% respuestas "Sí"
            $resultado = 'Bajo Riesgo';
            $mensaje = '✅ No se identifican señales significativas de maltrato en este momento.';
            $color = 'success';
            $recomendaciones = [
                'Mantén una comunicación abierta y respetuosa en tus relaciones.',
                'Sigue cuidando tu bienestar emocional y físico.',
                'Si en el futuro notas cambios, no dudes en buscar ayuda.',
                'Conoce las señales de relaciones saludables vs. no saludables.',
                'Apoya a otras personas que puedan estar en situaciones difíciles.'
            ];
        }

        // Crear registro del test en la BD
        $test = Test::create([
            'fecha' => Carbon::now(),
            'resultado' => $resultado,
            'fk_usuario' => $usuarioId,
        ]);

        // Guardar respuestas individuales
        foreach ($respuestas as $preguntaId => $valor) {
            RespuestaTest::create([
                'contenido' => $valor,
                'fk_pregunta' => $preguntaId,
                'fk_test' => $test->id_test,
            ]);
        }

        // Redirigir a la vista de resultados
        return view('test.resultado', [
            'resultado' => $resultado,
            'mensaje' => $mensaje,
            'color' => $color,
            'respuestasSi' => $respuestasSi,
            'totalPreguntas' => $cantidadPreguntas,
            'porcentajeAlerta' => round($porcentajeAlerta, 1),
            'recomendaciones' => $recomendaciones,
        ]);
    }

    /**
     * Ver historial de tests del usuario
     */
    public function historial()
    {
        if (!session('rol') || session('rol') !== 'usuario') {
            return redirect()->route('login.user')->with('error', 'Debes iniciar sesión como usuario');
        }

        $usuarioId = session('id');
        $tests = Test::where('fk_usuario', $usuarioId)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('test.historial', compact('tests'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioNotificacionConfig;
use App\Models\TipoNotificacion;
use App\Models\Notificacion;
use App\Models\FraseMotivacional;
use Carbon\Carbon;

class NotificacionMotivacionalController extends Controller
{
    private function usuarioId(): ?int
    {
        return session('id');
    }

    /**
     * Guardar o actualizar configuración de motivación.
     */
    public function guardarConfig(Request $request)
    {
        $request->validate([
            'frecuencia' => 'required|in:diaria,semanal,mensual'
        ]);

        $usuarioId = $this->usuarioId();
        if (!$usuarioId) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $config = UsuarioNotificacionConfig::updateOrCreate(
            ['fk_usuario' => $usuarioId],
            [
                'frecuencia' => $request->frecuencia,
                'intervalo_horas' => null,
                'activo' => true
            ]
        );

        return response()->json(['success' => true, 'config' => $config]);
    }

    /**
     * Obtener (y generar si corresponde) el siguiente mensaje motivacional.
     */
    public function siguiente()
    {
        $usuarioId = $this->usuarioId();
        if (!$usuarioId) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Asegurar tipo 'motivacional'
        $tipo = TipoNotificacion::firstOrCreate(
            ['nombre' => 'motivacional'],
            ['descripcion' => 'Mensajes motivacionales automáticos']
        );

        $config = UsuarioNotificacionConfig::firstOrCreate(
            ['fk_usuario' => $usuarioId],
            ['frecuencia' => 'diaria']
        );

        if (!$config->activo) {
            return response()->json(['mensaje' => null, 'motivo' => 'desactivado']);
        }

        $intervaloHoras = $config->intervaloEfectivoHoras();
        $ahora = Carbon::now();
        $ultima = $config->ultima_entrega ? Carbon::parse($config->ultima_entrega) : null;

        $debeEnviar = !$ultima || $ahora->diffInHours($ultima) >= $intervaloHoras;

        if ($debeEnviar) {
            // Tomar frase aleatoria del catálogo; fallback a lista corta si no hay datos
            $frase = FraseMotivacional::where('activo', true)->inRandomOrder()->value('texto');
            if (!$frase) {
                $fallback = [
                    'Cada paso pequeño cuenta hacia tu bienestar.',
                    'Eres más fuerte de lo que piensas.',
                    'Tu historia aún se está escribiendo, sigue adelante.',
                    'Está bien pedir ayuda, es un acto de valentía.',
                    'Hoy es una nueva oportunidad para sanar.'
                ];
                $frase = $fallback[array_rand($fallback)];
            }

            $notificacion = Notificacion::create([
                'fecha_hora' => $ahora->toDateTimeString(),
                'mensaje' => $frase,
                'fk_tipo_notificacion' => $tipo->id_tipo_notificacion,
                'fk_usuario' => $usuarioId,
                'leida' => 0
            ]);

            $config->update(['ultima_entrega' => $ahora->toDateTimeString()]);

            return response()->json(['mensaje' => $notificacion->mensaje, 'nueva' => true]);
        }

        // Si no es momento, devolver null
        return response()->json(['mensaje' => null, 'nueva' => false, 'proxima_horas' => $intervaloHoras - $ahora->diffInHours($ultima)]);
    }

    /** Marcar notificación como leída */
    public function marcarLeida(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $n = Notificacion::where('id_notificacion', $request->id)->where('fk_usuario', $this->usuarioId())->first();
        if (!$n) return response()->json(['error' => 'No encontrada'], 404);
        $n->leida = 1; $n->save();
        return response()->json(['success' => true]);
    }
}

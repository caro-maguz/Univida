<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Mostrar formulario para solicitar recuperación de contraseña
     */
    public function mostrarFormularioSolicitud()
    {
        return view('auth.forgot-password');
    }

    /**
     * Procesar solicitud de recuperación y generar código de 4 dígitos
     */
    public function enviarTokenRecuperacion(Request $request)
    {
        $request->validate([
            'correo' => 'required|email'
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Debe ser un correo válido.'
        ]);

        $correo = $request->correo;

        // Verificar que el usuario existe
        $usuario = DB::table('usuario')->where('correo', $correo)->first();

        if (!$usuario) {
            return back()->withErrors(['correo' => 'No existe una cuenta con este correo.']);
        }

        // Generar código de 4 dígitos
        $codigo = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Eliminar códigos anteriores de este correo
        DB::table('password_reset_tokens')->where('email', $correo)->delete();

        // Guardar nuevo código (hasheado)
        DB::table('password_reset_tokens')->insert([
            'email' => $correo,
            'token' => Hash::make($codigo),
            'created_at' => Carbon::now()
        ]);

        // Intentar enviar email
        $emailEnviado = false;
        try {
            \Mail::raw(
                "Hola,\n\nHas solicitado recuperar tu contraseña en Univida.\n\n" .
                "Tu código de verificación es: {$codigo}\n\n" .
                "Este código expira en 15 minutos.\n\n" .
                "Si no solicitaste este cambio, ignora este correo.\n\n" .
                "Saludos,\nEquipo Univida",
                function($message) use ($correo) {
                    $message->to($correo)
                            ->subject('Código de Recuperación - Univida');
                }
            );
            $emailEnviado = true;
        } catch (\Exception $e) {
            // Si falla el envío de email, continuar y mostrar código en pantalla
            $emailEnviado = false;
        }

        return view('auth.codigo-generated', [
            'codigo' => $codigo,
            'correo' => $correo,
            'emailEnviado' => $emailEnviado
        ]);
    }

    /**
     * Mostrar formulario para restablecer contraseña con código
     */
    public function mostrarFormularioRestablecimiento()
    {
        return view('auth.reset-password');
    }

    /**
     * Procesar restablecimiento de contraseña con código de 4 dígitos
     */
    public function restablecerContrasena(Request $request)
    {
        $request->validate([
            'codigo' => 'required|digits:4',
            'correo' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.digits' => 'El código debe ser de 4 dígitos.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Debe ser un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Buscar el código en la base de datos
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->correo)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['correo' => 'No hay solicitud de recuperación para este correo.'])->withInput();
        }

        // Verificar que el código coincida
        if (!Hash::check($request->codigo, $resetRecord->token)) {
            return back()->withErrors(['codigo' => 'El código ingresado no es válido.'])->withInput();
        }

        // Verificar que el código no haya expirado (15 minutos)
        $createdAt = Carbon::parse($resetRecord->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 15) {
            DB::table('password_reset_tokens')->where('email', $request->correo)->delete();
            return back()->withErrors(['codigo' => 'El código ha expirado. Solicita uno nuevo.'])->withInput();
        }

        // Actualizar la contraseña del usuario
        DB::table('usuario')
            ->where('correo', $request->correo)
            ->update([
                'contrasena' => Hash::make($request->password)
            ]);

        // Eliminar el código usado
        DB::table('password_reset_tokens')->where('email', $request->correo)->delete();

        // Redirigir al login con mensaje de éxito
        return redirect()->route('login.user')->with('success', '¡Contraseña restablecida exitosamente! Ya puedes iniciar sesión.');
    }
}

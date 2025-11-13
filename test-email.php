<?php

use Illuminate\Support\Facades\Mail;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔄 Probando envío de email...\n\n";

try {
    Mail::raw('Este es un email de prueba desde Univida. Si recibes esto, la configuración de email funciona correctamente!', function($message) {
        $message->to('ivan.urbano.m@uniautonoma.edu.co')
                ->subject('Prueba de Email - Univida');
    });
    
    echo "✅ ¡Email enviado correctamente!\n";
    echo "📧 Revisa tu bandeja de entrada: ivan.urbano.m@uniautonoma.edu.co\n";
    echo "⚠️  Si no lo ves, revisa la carpeta de SPAM\n";
} catch (\Exception $e) {
    echo "❌ Error al enviar email:\n";
    echo "   " . $e->getMessage() . "\n\n";
    echo "💡 Verifica:\n";
    echo "   - Que la contraseña de aplicación sea correcta\n";
    echo "   - Que tengas internet\n";
    echo "   - Que la verificación en 2 pasos esté activada en Gmail\n";
}

echo "\n✅ Script completado\n";

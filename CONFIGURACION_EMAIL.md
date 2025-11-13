# Configuración de Email para Sistema de Recuperación

## 📧 Configuración SMTP en `.env`

Para que el sistema envíe códigos de verificación por email, agrega estas líneas a tu archivo `.env`:

### Opción 1: Gmail (Recomendado para desarrollo)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@univida.com
MAIL_FROM_NAME="Univida"
```

**Nota Gmail:** Debes generar una "Contraseña de aplicación" en tu cuenta Google:
1. Ve a https://myaccount.google.com/security
2. Activa "Verificación en 2 pasos"
3. Genera una "Contraseña de aplicación"
4. Usa esa contraseña en `MAIL_PASSWORD`

### Opción 2: Mailtrap (Para desarrollo/testing)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu-username-mailtrap
MAIL_PASSWORD=tu-password-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@univida.com
MAIL_FROM_NAME="Univida"
```

Crea una cuenta gratuita en: https://mailtrap.io

### Opción 3: Outlook/Hotmail
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@outlook.com
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@univida.com
MAIL_FROM_NAME="Univida"
```

## 🧪 Probar Configuración

Después de configurar, ejecuta en la terminal:

```bash
php artisan tinker
```

Y luego:

```php
Mail::raw('Test email', function($message) {
    $message->to('tu-email@ejemplo.com')
            ->subject('Prueba de Email');
});
```

Si ves un error, revisa la configuración. Si todo sale bien, recibirás el email de prueba.

## 🔄 Comportamiento Actual

- **Si el email está configurado:** Se enviará el código de 4 dígitos por correo
- **Si el email NO está configurado:** El código se mostrará en pantalla (modo desarrollo)

Esto permite que el sistema funcione incluso sin configuración de email.

## ✅ Verificar que funciona

1. Ve a: http://127.0.0.1:8000/forgot-password
2. Ingresa un correo registrado
3. Si está configurado SMTP: Verás "✅ ¡Email enviado!"
4. Si NO está configurado: Verás "⚠️ MODO DE DESARROLLO" con el código visible

## 📝 Formato del Email

El email enviado contiene:

```
Asunto: Código de Recuperación - Univida

Hola,

Has solicitado recuperar tu contraseña en Univida.

Tu código de verificación es: 1234

Este código expira en 15 minutos.

Si no solicitaste este cambio, ignora este correo.

Saludos,
Equipo Univida
```

## 🚀 Para Mejorar en Producción

Puedes crear una plantilla HTML más bonita usando Laravel Mailable:

```bash
php artisan make:mail CodigoRecuperacionMail
```

Y modificar el controlador para usar la plantilla personalizada.

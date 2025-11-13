# Sistema de Recuperación de Contraseña - Univida

## 📋 Resumen del Sistema

El sistema de recuperación de contraseña permite a los usuarios restablecer su contraseña de forma segura usando **códigos de verificación de 4 dígitos** enviados por email con expiración de 15 minutos.

## 🔧 Componentes Implementados

### 1. **Controlador**: `PasswordResetController.php`
Ubicación: `app/Http/Controllers/PasswordResetController.php`

**Métodos:**
- `mostrarFormularioSolicitud()` - Muestra el formulario para solicitar recuperación
- `enviarTokenRecuperacion()` - Genera el token y lo almacena en BD
- `mostrarFormularioRestablecimiento($token)` - Muestra el formulario para ingresar nueva contraseña
- `restablecerContrasena()` - Valida el token y actualiza la contraseña

### 2. **Vistas**
- `resources/views/auth/forgot-password.blade.php` - Solicitar recuperación
- `resources/views/auth/codigo-generated.blade.php` - Mostrar código generado
- `resources/views/auth/reset-password.blade.php` - Formulario con código y nueva contraseña

### 3. **Rutas** (en `routes/web.php`)
```php
Route::get('/forgot-password', [...])        ->name('password.request');
Route::post('/forgot-password', [...])       ->name('password.email');
Route::get('/reset-password/{token}', [...]) ->name('password.reset');
Route::post('/reset-password', [...])        ->name('password.update');
```

### 4. **Base de Datos**
Tabla: `password_reset_tokens`
- `email` (PK) - Correo del usuario
- `token` - Token hasheado con bcrypt
- `created_at` - Fecha de creación (para expiración)

## 🚀 Flujo de Usuario

1. **Solicitar Recuperación**
   - Usuario hace clic en "¿Olvidaste tu contraseña?" en login
   - Ingresa su correo institucional
   - Sistema valida que el correo exista

2. **Generación de Código**
   - Sistema genera código aleatorio de 4 dígitos (0000-9999)
   - Guarda el código hasheado en BD
   - Intenta enviar el código por email
   - Si falla el email, muestra el código en pantalla (modo desarrollo)

3. **Restablecer Contraseña**
   - Usuario accede al formulario de restablecimiento
   - Ingresa: correo, código de 4 dígitos, nueva contraseña y confirmación
   - Sistema valida el código y actualiza la contraseña

4. **Completado**
   - Usuario es redirigido al login con mensaje de éxito
   - Código es eliminado de la BD

## ⏱️ Características de Seguridad

- ✅ **Códigos únicos**: Cada solicitud genera un código diferente de 4 dígitos
- ✅ **Expiración rápida**: Los códigos expiran en 15 minutos
- ✅ **Hashing**: Los códigos se guardan hasheados con bcrypt
- ✅ **Uso único**: El código se elimina después de usarse
- ✅ **Validación de email**: Solo correos registrados pueden recuperar
- ✅ **Confirmación de contraseña**: Requiere escribir 2 veces la nueva contraseña
- ✅ **Validación de formato**: El código debe ser exactamente 4 dígitos

## 📧 Modo Desarrollo vs Producción

### Modo Automático
El sistema detecta automáticamente si puede enviar emails:

- **Con SMTP configurado:** 
  - Envía el código por email
  - Muestra mensaje "✅ ¡Email enviado!"
  - Código visible en pantalla también (para desarrollo)

- **Sin SMTP configurado:**
  - Muestra "⚠️ MODO DE DESARROLLO"
  - Código visible en pantalla
  - Usuario puede copiar el código directamente

### Email Enviado
El email contiene:
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

Ver `CONFIGURACION_EMAIL.md` para configurar SMTP.

## 🔗 URLs del Sistema

- Solicitar recuperación: `http://127.0.0.1:8000/forgot-password`
- Restablecer (con token): `http://127.0.0.1:8000/reset-password/{token}`
- Login: `http://127.0.0.1:8000/login`

## 🧪 Prueba del Sistema

1. Ir a: http://127.0.0.1:8000/login
2. Clic en "¿Olvidaste tu contraseña?"
3. Ingresar correo registrado (ej: `usuario@uniautonoma.edu.co`)
4. Ver el código de 4 dígitos (en pantalla o en email)
5. Clic en "Continuar al restablecimiento"
6. Ingresar: correo, código de 4 dígitos, nueva contraseña (2 veces)
7. Iniciar sesión con la nueva contraseña

**Ejemplo de código:** 1234, 5678, 0042, etc.

## ⚙️ Configuración Futura de Email

Para usar envío real de emails, configurar en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-password-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@univida.com
MAIL_FROM_NAME="Univida"
```

## 📝 Notas Técnicas

- Los códigos se guardan hasheados para mayor seguridad
- La tabla `password_reset_tokens` usa `email` como clave primaria
- Se elimina cualquier código anterior del mismo email al generar uno nuevo
- Las contraseñas se hashean con bcrypt antes de guardarse
- El sistema valida que el correo exista en la tabla `usuario`
- Los códigos son de 4 dígitos (0000-9999) con padding de ceros a la izquierda
- Tiempo de expiración: 15 minutos (más corto por ser código simple)
- El sistema intenta enviar email automáticamente, pero funciona sin SMTP

---

✅ **Estado**: Sistema completamente funcional con código de 4 dígitos
✅ **Modo híbrido**: Envía por email SI está configurado, muestra en pantalla SI NO
� **Opcional**: Ver `CONFIGURACION_EMAIL.md` para configurar envío de emails

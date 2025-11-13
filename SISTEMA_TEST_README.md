# Sistema de Test Psicológico - Univida

## ✅ Implementación Completada

Se ha implementado un sistema completo de evaluación psicológica para usuarios con las siguientes características:

## 📋 Componentes Implementados

### 1. Base de Datos
- ✅ **Tablas**: `test`, `pregunta_test`, `respuesta_test`
- ✅ **Modelos Laravel**: Test, PreguntaTest, RespuestaTest (actualizados con claves primarias correctas)
- ✅ **Seeder**: 15 preguntas sobre violencia de género y bienestar emocional

### 2. Controlador
**`TestController.php`** con 3 métodos:
- `mostrar()`: Muestra el formulario del test
- `procesar()`: Procesa respuestas y calcula resultado
- `historial()`: Muestra tests anteriores del usuario

### 3. Vistas
- ✅ **`test/realizar.blade.php`**: Formulario interactivo con 15 preguntas
  - Escala del 1 al 5 (Nunca → Siempre)
  - Barra de progreso
  - Validación en tiempo real
  
- ✅ **`test/resultado.blade.php`**: Página de resultados
  - 4 niveles de riesgo con colores distintivos
  - Recomendaciones personalizadas
  - Enlaces a recursos de apoyo
  
- ✅ **`test/historial.blade.php`**: Historial de tests realizados

### 4. Rutas
```php
Route::get('/test', [TestController::class, 'mostrar'])->name('test.mostrar');
Route::post('/test/procesar', [TestController::class, 'procesar'])->name('test.procesar');
Route::get('/test/historial', [TestController::class, 'historial'])->name('test.historial');
```

### 5. Navegación
- ✅ Botón "🧠 Realizar Test" en el dashboard del usuario
- ✅ Botón "📊 Mi Historial" para ver tests anteriores

## 🎯 Cómo Funciona

### Escala de Evaluación
- **1 = Nunca**
- **2 = Raramente**
- **3 = A veces**
- **4 = Frecuentemente**
- **5 = Siempre**

### Interpretación de Resultados

| Promedio | Resultado | Mensaje |
|----------|-----------|---------|
| ≤ 2.0 | **Riesgo Alto** 🔴 | Señales importantes que requieren atención inmediata |
| 2.1 - 3.0 | **Riesgo Moderado** 🟡 | Algunas señales de alerta identificadas |
| 3.1 - 4.0 | **Bajo Riesgo** 🔵 | Situación estable con señales leves |
| > 4.0 | **Sin Riesgo Aparente** ✅ | No se identifican señales de riesgo |

## 🧪 Prueba el Sistema

1. **Iniciar sesión como usuario**
   ```
   http://localhost:8000/login
   ```

2. **Acceder al test desde el dashboard**
   - Clic en "🧠 Realizar Test"
   - O directamente: `http://localhost:8000/test`

3. **Responder las 15 preguntas**
   - Selecciona la opción que mejor describe tu situación
   - La barra de progreso se actualiza en tiempo real
   - El botón "Enviar" se habilita solo cuando todas las preguntas están respondidas

4. **Ver resultados**
   - Nivel de riesgo con color distintivo
   - Puntuación total y promedio
   - Recomendaciones personalizadas
   - Enlaces directos a chat de apoyo y recursos

5. **Consultar historial**
   - Clic en "📊 Mi Historial" en el dashboard
   - O directamente: `http://localhost:8000/test/historial`

## 🔐 Seguridad y Privacidad

- ✅ Rutas protegidas con middleware `auth.usuario`
- ✅ Validación de todas las respuestas
- ✅ Resultados confidenciales (solo visibles para el usuario)
- ✅ Tests vinculados al ID del usuario en sesión

## 📊 Preguntas del Test

El test incluye 15 preguntas sobre:
- Respeto y control en la relación
- Amenazas e intimidación
- Violencia física y psicológica
- Libertad de expresión y decisión
- Autoestima y aislamiento social
- Presión sexual
- Bienestar emocional general

## 🎨 Diseño

- Paleta de colores consistente con Univida (azul #004aad, amarillo #ffc107)
- Tipografía Delius (fuente cursiva característica)
- Diseño responsivo
- Animaciones y transiciones suaves
- Iconos y emojis para mejor UX

## 🔧 Archivos Modificados/Creados

### Nuevos Archivos
- `app/Http/Controllers/TestController.php`
- `database/seeders/PreguntaTestSeeder.php`
- `resources/views/test/realizar.blade.php`
- `resources/views/test/resultado.blade.php`
- `resources/views/test/historial.blade.php`

### Archivos Modificados
- `app/Models/Test.php` (agregado primaryKey y timestamps)
- `app/Models/PreguntaTest.php` (agregado primaryKey y relaciones)
- `app/Models/RespuestaTest.php` (agregado primaryKey)
- `routes/web.php` (agregadas 3 rutas del test)
- `resources/views/dashboard-user.blade.php` (agregados 2 botones)

## ✨ Próximas Mejoras Sugeridas

- [ ] Gráficas de evolución en el historial
- [ ] Comparación entre tests (mejoría/empeoramiento)
- [ ] Notificaciones automáticas basadas en resultados
- [ ] Export de resultados en PDF
- [ ] Test específicos por tipo de violencia
- [ ] Recordatorios para realizar test periódicos

## 🚀 Comandos Ejecutados

```bash
# Insertar preguntas en la BD
php artisan db:seed --class=PreguntaTestSeeder

# Verificar rutas
php artisan route:list --name=test

# Verificar preguntas
php artisan tinker --execute="echo App\Models\PreguntaTest::count();"
```

---

**Desarrollado para Univida** 💙  
*Sistema de apoyo para víctimas de violencia de género*

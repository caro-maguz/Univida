<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario_notificacion_config', function (Blueprint $table) {
            $table->id('id_config');
            $table->unsignedInteger('fk_usuario');
            // Frecuencia predefinida: diaria, semanal, mensual, personalizada
            $table->enum('frecuencia', ['diaria','semanal','mensual','personalizada'])->default('diaria');
            // En caso de personalizada: intervalo en horas
            $table->unsignedInteger('intervalo_horas')->nullable();
            // Fecha/hora de la última notificación motivacional enviada
            $table->dateTime('ultima_entrega')->nullable();
            // Activado/desactivado por el usuario
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->unique('fk_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_notificacion_config');
    }
};

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
        Schema::table('historias', function (Blueprint $table) {
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente')->after('usuario_id');
            $table->integer('moderador_id')->nullable()->after('estado');
            $table->timestamp('fecha_moderacion')->nullable()->after('moderador_id');
            $table->text('motivo_rechazo')->nullable()->after('fecha_moderacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias', function (Blueprint $table) {
            $table->dropColumn(['estado', 'moderador_id', 'fecha_moderacion', 'motivo_rechazo']);
        });
    }
};

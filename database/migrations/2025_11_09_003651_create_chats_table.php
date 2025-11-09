<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('psicologo_id')->nullable();
            $table->enum('estado', ['activo', 'finalizado', 'en_espera'])->default('en_espera');
            $table->timestamp('iniciado_en')->useCurrent();
            $table->timestamp('finalizado_en')->nullable();
            $table->timestamps();
            
            // Relaciones ajustadas a TUS tablas
            $table->foreign('usuario_id')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('psicologo_id')->references('id_psicologo')->on('psicologo')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
};
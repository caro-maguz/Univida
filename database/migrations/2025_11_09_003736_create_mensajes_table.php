<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->enum('tipo_remitente', ['usuario', 'psicologo', 'sistema']);
            $table->unsignedBigInteger('remitente_id')->nullable();
            $table->text('mensaje');
            $table->boolean('leido')->default(false);
            $table->timestamps();
            
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mensajes');
    }
};
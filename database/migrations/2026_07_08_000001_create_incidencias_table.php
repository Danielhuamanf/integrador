<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->integer('id_incidencia', true);
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->enum('prioridad', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->enum('estado', ['abierto', 'en_proceso', 'resuelto', 'cerrado'])->default('abierto');
            $table->string('categoria', 100)->nullable();
            $table->integer('id_usuario_creador');
            $table->integer('id_usuario_asignado')->nullable();
            $table->timestamps();
        });

        Schema::create('incidencia_comentarios', function (Blueprint $table) {
            $table->integer('id_comentario', true);
            $table->integer('id_incidencia');
            $table->integer('id_usuario');
            $table->text('comentario');
            $table->timestamps();

            $table->foreign('id_incidencia')->references('id_incidencia')->on('incidencias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencia_comentarios');
        Schema::dropIfExists('incidencias');
    }
};

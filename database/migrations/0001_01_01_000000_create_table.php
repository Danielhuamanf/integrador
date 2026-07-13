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
        Schema::create('usuarios', function (Blueprint $table) {

            $table->id('id_usuario');

            $table->string('correo', 100);

            $table->string('password', 200);

            $table->string('username', 50);

            $table->integer('rol');

            $table->timestamps();

        });

       Schema::create('cliente', function (Blueprint $table) {

            $table->id('id_cliente');

            $table->foreignId('id_usuario')
                  ->constrained('usuarios', 'id_usuario')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->string('tipo_persona', 10);

            $table->string('nombre_completo', 200);

            $table->string('correo', 150);

            $table->string('telefono', 20);

            $table->string('direccion', 300);

            $table->char('ubigeo', 6);

            $table->string('estado', 20);

            $table->char('ruc', 11);

            $table->string('nombre_comercial', 200);

            $table->string('representante_legal', 150);

            $table->integer('dni');

            $table->timestamps();

        });

      Schema::create('zonas', function (Blueprint $table) {

            $table->id('id_zona');

            $table->string('nombre_zona', 200);

            $table->string('descripcion', 300);

            $table->string('direccion', 300);

        });
      Schema::create('almacen', function (Blueprint $table) {

        $table->id('id_almacen');

        $table->string('nombre_almacen', 100);

        $table->string('direccion', 300);

        $table->string('nombre_responsable', 150);

        $table->string('numero_responsable', 15);

        $table->integer('tipo');

        $table->boolean('estado');

        $table->float('capacidad_m3');

        $table->timestamps();

    });
      Schema::create('estados_envio', function (Blueprint $table) {

        $table->id('id_estado');

        $table->string('nombre', 100)->nullable();

    });
      Schema::create('tipo_envio', function (Blueprint $table) {

        $table->id('id_tipo');

        $table->string('nombre', 50)->nullable();

    });
      Schema::create('envio', function (Blueprint $table) {

        $table->id('id_envio');

        $table->foreignId('id_cliente')
              ->constrained('cliente', 'id_cliente')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreignId('id_zona_origen')
              ->constrained('zonas', 'id_zona')
              ->onUpdate('cascade');

        $table->foreignId('id_zona_destino')
              ->constrained('zonas', 'id_zona')
              ->onUpdate('cascade');

        $table->float('peso');

        $table->float('volumen');

        $table->text('descripcion')->nullable();

        $table->decimal('valor_declarado', 10, 2)->nullable();

        $table->foreignId('tipo_envio')
              ->nullable()
              ->constrained('tipo_envio', 'id_tipo');

        $table->foreignId('estado')
              ->nullable()
              ->constrained('estados_envio', 'id_estado')
              ->nullOnDelete()
              ->onUpdate('cascade');

        $table->dateTime('fecha_envio')->nullable();

        $table->dateTime('fecha_entrega')->nullable();

        $table->foreignId('id_almacen_origen')
              ->nullable()
              ->constrained('almacen', 'id_almacen')
              ->nullOnDelete()
              ->onUpdate('cascade');

        $table->foreignId('id_almacen_destino')
              ->nullable()
              ->constrained('almacen', 'id_almacen')
              ->nullOnDelete()
              ->onUpdate('cascade');

        $table->timestamps();

    });
      Schema::create('envio_detalle', function (Blueprint $table) {

        $table->id('id_detalle');

        $table->foreignId('id_envio')
              ->constrained('envio', 'id_envio')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->string('descripcion', 200)->nullable();

        $table->integer('cantidad')->nullable();

        $table->float('peso_unitario')->nullable();

        $table->decimal('valor_unitario', 10, 2)->nullable();

        $table->string('partida_arancelaria', 20)->nullable();

        $table->timestamp('created_at')->useCurrent();

    });
      Schema::create('tracking', function (Blueprint $table) {

        $table->id('id_tracking');

        $table->foreignId('id_envio')
              ->constrained('envio', 'id_envio')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->foreignId('id_estado')
              ->constrained('estados_envio', 'id_estado')
              ->onUpdate('cascade');

        $table->string('ubicacion', 200)->nullable();

        $table->dateTime('fecha')->nullable();

        $table->text('comentario')->nullable();

    });
      Schema::create('documentos', function (Blueprint $table) {

        $table->id('id_documento');

        $table->foreignId('id_envio')
              ->constrained('envio', 'id_envio')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->string('nombre_doc', 200);

        $table->string('url_documento', 100);

        $table->string('descripcion_doc', 300);

        $table->timestamp('created_at')->useCurrent();

    });
      Schema::create('dam', function (Blueprint $table) {

        $table->id('id_dam');

        $table->foreignId('id_envio')
              ->unique()
              ->constrained('envio', 'id_envio')
              ->onDelete('cascade')
              ->onUpdate('cascade');

        $table->string('numero_dam', 50)->nullable();

        $table->string('canal_control', 20)->nullable();

        $table->date('fecha_numeracion')->nullable();

        $table->string('aduana', 100)->nullable();

        $table->string('estado', 50)->nullable();

        $table->timestamp('created_at')->useCurrent();

    });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking');

        Schema::dropIfExists('dam');

        Schema::dropIfExists('documentos');

        Schema::dropIfExists('envio_detalle');

        Schema::dropIfExists('costos_envio');

        Schema::dropIfExists('dam_costos');

        Schema::dropIfExists('pagos');

        Schema::dropIfExists('mensajes');

        Schema::dropIfExists('precios');

        Schema::dropIfExists('leads');

        Schema::dropIfExists('envio');

        Schema::dropIfExists('cliente');

        Schema::dropIfExists('usuarios');

        Schema::dropIfExists('almacen');

        Schema::dropIfExists('zonas');

        Schema::dropIfExists('estados_envio');

        Schema::dropIfExists('tipo_envio');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('sessions');
    }
};

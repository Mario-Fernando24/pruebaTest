<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento')->nullable();
            $table->string('num_documento')->unique();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('latitud')->nullable(); 
            $table->string('longitud')->nullable(); 
            $table->boolean('estado')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}

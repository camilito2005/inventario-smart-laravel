<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('categorias')) { // Verifica si la tabla existe
            Schema::create('categorias', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('categorias'); // Elimina la tabla si existe
    }
}

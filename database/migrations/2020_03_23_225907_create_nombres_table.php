<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNombresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nombres', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
        Schema::create('instituciones', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('nombre');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
        Schema::create('cursos', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('nombre');
            $table->bigInteger('institucion_id')->unsigned();
            $table->foreign('institucion_id')->references('id')->on('instituciones');
            $table->bigInteger('nombre_id')->unsigned();
            $table->foreign('nombre_id')->references('id')->on('nombres');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('nombres');
    }
}

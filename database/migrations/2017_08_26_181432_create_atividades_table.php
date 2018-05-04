<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_processo');
            $table->integer('usuario');
            $table->date('data_conciliacao')->nullable();
            $table->timestamp('hora_inicio')->nullable();
            $table->timestamp('hora_fim')->nullable();
            $table->date('data_meta')->nullable();
            $table->date('data_conciliada');
            $table->date('ultima_data')->nullable();
            $table->string('coop')->nullable();
            $table->string('assunto')->nullable();
            $table->string('solicitante')->nullable();
            $table->string('obs')->nullable();
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
        Schema::dropIfExists('atividades');
    }
}

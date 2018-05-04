<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoIndic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_indic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('processo_id');
            $table->date('data_informada');
            $table->integer('user_id');
            $table->date('ultima_data')->nullable();
            $table->date('data_meta');
            $table->integer('periodiciade_id');
            $table->string('status');          
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
        Schema::dropIfExists('historico_indic');
    }
}

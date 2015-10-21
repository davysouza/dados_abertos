<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dags', function (Blueprint $table) {
			$table->increments('id');
			$table->string('cidade');
			$table->date('mes_ano');
			$table->string('credor_secretaria');
			$table->string('funcao');
			$table->string('subfuncao');
			$table->string('fonte_de_recurso');
			$table->double('valor_pago_acumulado');
			$table->string('natureza_da_despesa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dags');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->unique();
            $table->double('area');
            $table->integer('populacao');
            $table->integer('cresc_populacional');
            $table->double('pib');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('cities');
    }
}

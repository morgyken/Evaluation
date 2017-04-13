<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientPreliminaryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_preliminary', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->string('entity');
            $column->string('left');
            $column->string('right');
            $column->string('remarks');
            $column->integer('user')->unsigned()->nullable();
            $column->timestamps();

            $column->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('evaluation_preliminary');
    }

}

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
        Schema::create('patient_preliminary', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->string('entity');
            $column->string('left');
            $column->string('right');
            $column->string('remarks');
            $column->integer('user')->unsigned();
            $column->timestamps();

            $column->foreign('visit')
                    ->references('visit_id')
                    ->on('patient_visits')
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
        Schema::drop('patient_preliminary');
    }

}

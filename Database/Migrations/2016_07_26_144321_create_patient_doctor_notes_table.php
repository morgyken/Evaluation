<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientDoctorNotesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_doctor_notes', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->longText('presenting_complaints')->nullable();
            $column->longText('past_medical_history')->nullable();
            $column->longText('examination')->nullable();
            $column->longText('diagnosis')->nullable();
            $column->longText('treatment_plan')->nullable();
            $column->integer('user')->unsigned()->nullable();
            $column->timestamps();

            $column->foreign('visit')
                    ->references('visit_id')
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
        Schema::drop('evaluation_doctor_notes');
    }

}

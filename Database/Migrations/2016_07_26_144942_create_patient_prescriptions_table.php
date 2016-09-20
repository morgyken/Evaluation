<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientPrescriptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('patient_prescriptions', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->string('drug');
            $column->string('take');
            $column->integer('whereto');
            $column->integer('method');
            $column->string('duration');
            $column->boolean('allow_substitution');

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
        Schema::drop('patient_prescriptions');
    }

}

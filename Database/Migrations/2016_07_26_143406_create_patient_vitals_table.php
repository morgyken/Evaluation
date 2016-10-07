<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientVitalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_vitals', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->double('weight', 10, 2)->nullable();
            $column->double('height', 10, 2)->nullable();
            $column->string('bp_systolic')->nullable();
            $column->string('bp_diastolic')->nullable();
            $column->string('pulse')->nullable();
            $column->string('respiration')->nullable();
            $column->string('temperature')->nullable();
            $column->string('temperature_location')->nullable();
            $column->double('oxygen', 10, 2)->nullable();
            $column->double('waist', 10, 2)->nullable();
            $column->double('hip', 10, 2)->nullable();
            $column->string('blood_sugar')->nullable();
            $column->string('blood_sugar_units')->default('mmol/L');
            $column->string('allergies')->nullable();
            $column->longText('chronic_illnesses')->nullable();
            $column->longText('nurse_notes')->nullable();
            $column->integer('user')->unsigned()->nullable();
            $column->timestamps();

            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
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
        Schema::drop('evaluation_vitals');
    }

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientVisitsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_visits', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('clinic')->unsigned();
            $column->integer('patient')->unsigned();
            $column->integer('purpose')->nullable()->unsigned();
            //payments
            $column->integer('user')->unsigned();
            $column->string('payment_mode')->default('cash');
            $column->integer('scheme')->unsigned()->nullable();
            $column->integer('next_appointment')->unsigned()->nullable();
            $column->softDeletes();
            $column->timestamps();

            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $column->foreign('patient')
                    ->references('id')
                    ->on('reception_patients')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('clinic')
                    ->references('id')
                    ->on('settings_clinics')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $column->foreign('scheme')->references('id')
                    ->on('reception_patient_schemes')
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
        Schema::drop('evaluation_visits');
    }

}

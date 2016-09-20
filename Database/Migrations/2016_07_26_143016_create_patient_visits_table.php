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
        Schema::create('patient_visits', function(Blueprint $column) {
            $column->increments('visit_id');
            $column->integer('clinic')->unsigned();
            $column->integer('patient')->unsigned();
            $column->integer('purpose')->nullable()->unsigned();
            $column->integer('destination')->nullable()->unsigned();
            //module details
            $column->boolean('nurse')->default(false);
            $column->dateTime('nurse_out')->nullable();
            $column->boolean('theatre')->default(false);
            $column->dateTime('theatre_out')->nullable();
            $column->boolean('diagnostics')->default(false);
            $column->dateTime('diagnostics_out')->nullable();
            $column->boolean('evaluation')->default(false);
            $column->dateTime('evaluation_out')->nullable();
            $column->boolean('laboratory')->default(false);
            $column->dateTime('laboratory_out')->nullable();
            $column->boolean('radiology')->default(false);
            $column->dateTime('radiology_out')->nullable();
            $column->boolean('pharmacy')->default(false);
            $column->dateTime('pharmacy_out')->nullable();
            $column->boolean('optical')->default(false);
            $column->dateTime('optical_out')->nullable();
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
            $column->foreign('destination')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('patient')
                    ->references('id')
                    ->on('patients')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('clinic')
                    ->references('id')
                    ->on('clinics')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $column->foreign('scheme')->references('id')->on('schemes')
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
        Schema::drop('visits');
    }

}

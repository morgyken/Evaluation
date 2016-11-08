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
        Schema::create('evaluation_prescriptions', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->string('drug');
            $column->string('take');
            $column->integer('whereto');
            $column->integer('method');
            $column->string('duration');
            $column->integer('time_measure')
                    ->unsigned()
                    ->after('duration')
                    ->nullable()
                    ->default(1);
            $column->boolean('allow_substitution');

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
        Schema::drop('evaluation_prescriptions');
    }

}

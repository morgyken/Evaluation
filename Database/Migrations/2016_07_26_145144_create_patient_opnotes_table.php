<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientOpnotesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_opnotes', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->longText('surgery_indication')->nullable();
            $column->longText('implants')->nullable();
            $column->longText('postop')->nullable();
            $column->dateTime('date')->nullable();
            $column->integer('doctor')->unsigned()->nullable();
            $column->longText('indication')->nullable();
            $column->integer('user')->unsigned();
            $column->timestamps();
            $column->foreign('visit')
                    ->references('visit_id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $column->foreign('doctor')->references('id')->on('users')
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
        Schema::drop('evaluation_opnotes');
    }

}

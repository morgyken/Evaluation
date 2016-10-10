<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientTreatmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_treatments', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->integer('procedure')->unsigned();
            $column->double('price', 10, 2);
            $column->double('base', 10, 2);
            $column->boolean('is_paid')->default(false);
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
        Schema::drop('evaluation_treatments');
    }

}

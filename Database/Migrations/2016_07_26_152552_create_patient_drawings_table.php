<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientDrawingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_drawings', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->longText('object')->nullable();
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
        Schema::drop('evaluation_drawings');
    }

}

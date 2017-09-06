<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientInvestigationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_investigations', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('visit');
            $column->string('type')->default('diagnosis');
            $column->unsignedInteger('procedure');
            $column->double('price', 10, 2);
            $column->integer('user')->unsigned()->nullable();
            $column->longText('instructions')->nullable();
            $column->boolean('ordered')->default(false);
            $column->timestamps();

            $column->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('procedure')
                    ->references('id')
                    ->on('evaluation_procedures')
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
        Schema::drop('evaluation_investigations');
    }

}

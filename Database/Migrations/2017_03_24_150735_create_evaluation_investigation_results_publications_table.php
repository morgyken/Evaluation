<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationInvestigationResultsPublicationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_investigation_results_publications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('result')->unsigned();
            $table->string('type')->nullable();
            $table->string('reason')->nullable();
            $table->integer('user')->unsigned();
            $table->timestamps();

            $table->foreign('user')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('result')
                    ->references('id')
                    ->on('evaluation_investigation_results')
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
        Schema::dropIfExists('evaluation_investigation_results_publications');
    }

}

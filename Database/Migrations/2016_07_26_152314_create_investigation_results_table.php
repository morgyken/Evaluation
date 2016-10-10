<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestigationResultsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_investigation_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investigation')->unsigned();
            $table->integer('user')->unsigned()->nullable();
            $table->longText('instructions')->nullable();
            $table->longText('results')->nullable()->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('investigation')
                    ->references('id')
                    ->on('evaluation_investigations')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
        DB::statement("ALTER TABLE evaluation_investigation_results ADD file LONGBLOB AFTER results");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('evaluation_investigation_results');
    }

}
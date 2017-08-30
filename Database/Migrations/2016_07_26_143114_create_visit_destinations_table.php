<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitDestinationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_visit_destinations', function (Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->integer('user')->unsigned();
            $column->integer('destination')->unsigned()->nullable();
            /*
             * Department can be :
             * - nurse
             * - doctor
             * - theatre
             * - diagnostics
             * - lab
             * - radiology
             * - pharmacy
             * - optical
             */
            $column->string('department');
            $column->boolean('checkout')->default(false);
            $column->dateTime('begin_at')->nullable();
            $column->dateTime('finish_at')->nullable();
            $column->softDeletes();
            $column->timestamps();
            $column->unique(['visit','department']);
            $column->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('destination')->references('id')->on('users')
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
        Schema::dropIfExists('evaluation_visit_destinations');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_count', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('visit_id')->unsigned();
            $table->integer('test_id')->unsigned()->nullable();
            $table->integer('pages')->unsigned();

            $table->foreign('visit_id')
                ->references('id')
                ->on('evaluation_visits')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('test_id')
                ->references('id')
                ->on('evaluation_investigations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_count');
    }
}

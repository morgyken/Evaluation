<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSampleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_sample_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('procedure')->unsigned()->nullable();
            $table->string('details')->nullable();
            $table->timestamps();

            $table->foreign('procedure')
                ->references('id')
                ->on('evaluation_procedures')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sample_types');
    }
}

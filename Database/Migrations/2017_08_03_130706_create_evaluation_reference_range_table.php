<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationReferenceRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_reference_range', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procedure')->unsigned();
            $table->string('type');
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('lg_type')->nullable();
            $table->float('lower')->nullable();
            $table->float('upper')->nullable();
            $table->float('lg_value')->nullable();
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
        Schema::dropIfExists('evaluation_reference_range');
    }
}

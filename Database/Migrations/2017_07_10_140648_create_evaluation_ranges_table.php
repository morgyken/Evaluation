<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('evaluation_reference_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procedure')->unsigned();
            $table->string('type');
            $table->string('time_measure')->nullable();
            $table->string('gender')->nullable();
            $table->integer('time')->nullable();
            $table->integer('time_min')->nullable();
            $table->integer('time_max')->nullable();
            $table->string('less_greater')->nullable();
            $table->float('non_range')->nullable();
            $table->float('range_min')->nullable();
            $table->float('range_max')->nullable();
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
    public function down(){
        Schema::dropIfExists('evaluation_reference_ranges');
    }
}

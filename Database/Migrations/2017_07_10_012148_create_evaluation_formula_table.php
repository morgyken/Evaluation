<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationFormulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_formula', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procedure_id')->unsigned();
            $table->integer('template_id')->unsigned()->nullable();
            $table->string('formula');
            $table->timestamps();

            $table->foreign('procedure_id')
                ->references('id')
                ->on('evaluation_procedures')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('template_id')
                ->references('id')
                ->on('evaluation_templates_lab')
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
        Schema::dropIfExists('evaluation_formula');
    }
}

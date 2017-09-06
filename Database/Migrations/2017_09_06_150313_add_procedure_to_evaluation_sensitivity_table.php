<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProcedureToEvaluationSensitivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_sensitivity', function (Blueprint $table) {
            $table->integer('procedure_id')
                ->unsigned()
                ->after('test_id')
                ->nullable();
            $table->foreign('procedure_id')
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
        Schema::table('evaluation_sensitivity', function (Blueprint $table) {

        });
    }
}

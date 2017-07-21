<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTestIdToEvaluationFormulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_formula', function (Blueprint $table) {
            $table->integer('test_id')->unsigned()->nullable()->after('procedure_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_formula', function (Blueprint $table) {
            $table->removeColumn(['test_id']);
        });
    }
}

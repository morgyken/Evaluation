<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResultIdToEvaluationSensitivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_sensitivity', function (Blueprint $table) {
            $table->integer('result_id')->unsigned()->nullable()->after('test_id');
            $table->foreign('result_id')
                ->references('id')
                ->on('evaluation_investigation_results')
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

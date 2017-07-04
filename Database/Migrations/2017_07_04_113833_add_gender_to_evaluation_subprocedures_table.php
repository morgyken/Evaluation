<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderToEvaluationSubproceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_subprocedures', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('units');
            $table->string('method')->nullable()->after('lab_sample_type');
            $table->string('turn_around_time')->nullable()->after('method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_subprocedures', function (Blueprint $table) {

        });
    }
}

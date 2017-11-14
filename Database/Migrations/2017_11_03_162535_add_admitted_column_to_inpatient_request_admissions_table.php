<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdmittedColumnToInpatientRequestAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inpatient_request_admissions', function (Blueprint $table) {

            $table->boolean('admitted');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inpatient_request_admissions', function (Blueprint $table) {

            $table->dropColumn('admitted');

        });
    }
}

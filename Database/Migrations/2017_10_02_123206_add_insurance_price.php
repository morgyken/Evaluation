<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInsurancePrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_procedures', function (Blueprint $table) {
            $table->double('insurance_charge', 10, 2)->nullable()->after('cash_charge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_procedures', function (Blueprint $table) {
            $table->dropColumn('insurance_charge');
        });
    }
}

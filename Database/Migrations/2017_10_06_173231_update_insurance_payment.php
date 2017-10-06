<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInsurancePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_investigations', function (Blueprint $table) {
            $table->unsignedInteger('invoiced')->change();
        });
        Schema::table('evaluation_prescription_payments', function (Blueprint $table) {
            $table->unsignedInteger('invoiced')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

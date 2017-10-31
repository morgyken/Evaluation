<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationCopayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_copay', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit_id');
            $table->integer('scheme_id');
            $table->string('amount');
            $table->string('payment_status')->default(0);
            $table->integer('invoiced')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_copay');
    }
}

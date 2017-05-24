<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationExternalOrderDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_external_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('procedure_id')->unsigned();
            $table->timestamps();

            $table->foreign('order_id')
                    ->references('id')
                    ->on('evaluation_external_orders')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('procedure_id')
                    ->references('id')
                    ->on('evaluation_procedures')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('evaluation_external_order_details');
    }

}

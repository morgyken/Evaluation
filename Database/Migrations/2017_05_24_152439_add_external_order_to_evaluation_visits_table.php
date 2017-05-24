<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalOrderToEvaluationVisitsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('evaluation_visits', function (Blueprint $table) {
            $table->integer('external_order')->unsigned()->nullable();

            $table->foreign('external_order')
                    ->references('id')
                    ->on('evaluation_external_orders')
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
        Schema::table('evaluation_visits', function (Blueprint $table) {

        });
    }

}

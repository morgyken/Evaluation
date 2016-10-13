<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPaymentsCardTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_payments_card', function (Blueprint $column) {
            $column->increments('id');
            $column->integer('payment')->unsigned();
            $column->string('type');
            $column->string('name');
            $column->string('number');
            $column->string('expiry');
            $column->string('security')->defualt('000');
            $column->double('amount', 10, 2);
            $column->timestamps();

            $column->foreign('payment')->references('id')->on('evaluation_payments')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('evaluation_payments_card');
    }

}

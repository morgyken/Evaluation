<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationPaymentsChequeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_payments_cheque', function (Blueprint $column) {
            $column->increments('id');
            $column->integer('payment')->unsigned();
            $column->string('name')->nullable();
            $column->string('number')->nullable();
            $column->string('date')->nullable();
            $column->string('bank')->nullable();
            $column->string('bank_branch')->nullable();
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
        Schema::dropIfExists('evaluation_payments_cheque');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPricesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('company_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procedure')->unsigned();
            $table->integer('company')->unsigned();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('company')
                    ->references('id')
                    ->on('settings_insurance')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('procedure')
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
        Schema::dropIfExists('company_prices');
    }

}

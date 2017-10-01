<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_prescription_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prescription_id');
            $table->double('price', 10, 2);
            $table->double('discount', 10, 2)->default(0);
            $table->double('cost', 10, 2)->default(0);
            $table->smallInteger('quantity');
            $table->boolean('paid')->default(false);
            $table->timestamps();
            $table->foreign('prescription_id')
                ->references('id')
                ->on('evaluation_prescriptions')
                ->onDelete('cascade')
                ->onUpdate('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_prescription_payments');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationExternalOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_external_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('institution')->unsigned();
            $table->integer('user')->unsigned();
            $table->string('description')->nullable();
            $table->string('status')->nullable();

            $table->foreign('patient_id')
                    ->references('id')
                    ->on('reception_patients')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('institution')
                    ->references('id')
                    ->on('evaluation_lab_partner_institutions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('user')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('evaluation_external_orders');
    }

}

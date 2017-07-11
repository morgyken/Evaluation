<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_samples', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('visit_id')->unsigned()->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->string('details')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')
                ->references('id')
                ->on('reception_patients')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('visit_id')
                ->references('id')
                ->on('evaluation_visits')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('evaluation_sample_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('samples');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientPrescriptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
       try{
        Schema::create('evaluation_prescriptions', function(Blueprint $column) {
            $column->increments('id');
            $column->unsignedInteger('admission_id')->nullable();
            $column->unsignedInteger('visit');
            $column->unsignedInteger('user');
            $column->string('drug');
            $column->integer('take');
            $column->integer('whereto');
            $column->integer('method');
            $column->integer('duration');
            $column->boolean('status')->default(false);
            $column->boolean('allow_substitution')->default(false);
            $column->integer('time_measure')->unsigned()->default(1);
            $column->timestamps();

            $column->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $column->foreign('admission_id')
                    ->references('id')
                    ->on('admissions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            });
       }catch (\Exception $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('evaluation_prescriptions');
    }

}

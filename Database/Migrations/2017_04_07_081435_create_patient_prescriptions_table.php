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
            $column->unsignedInteger('visit');
            $column->unsignedInteger('user');
            $column->string('drug');
            $column->integer('take');
            $column->integer('whereto');
            $column->integer('method');
            $column->integer('duration');
            $column->longText('stop_reason')->nullable();
            $column->boolean('stopped')->default(false);
            $column->boolean('status')->default(false);
            $column->boolean('allow_substitution')->default(false);
            $column->integer('time_measure')->unsigned()->default(1);
            $column->integer('quantity');
            //$column->integer('type')->default(0); // 0 - Once only, 1- regular
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

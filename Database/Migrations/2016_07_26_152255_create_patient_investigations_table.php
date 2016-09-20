<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePatientInvestigationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('patient_investigations', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->string('type')->default('diagnosis');
            $column->integer('test')->unsigned();
            $column->double('price', 10, 2);
            $column->double('base', 10, 2);
            $column->boolean('is_paid')->default(false);
            $column->integer('to_user')->unsigned()->nullable();
            $column->integer('from_user')->unsigned()->nullable();
            $column->longText('instructions')->nullable();
            $column->longText('results')->nullable();
            $column->integer('status')->default(1);
            $column->timestamps();
            $column->foreign('visit')
                    ->references('visit_id')
                    ->on('patient_visits')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
        DB::statement("ALTER TABLE patient_investigations ADD file LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('patient_investigations');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitMetasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_visit_metas', function(Blueprint $column) {
            $column->integer('visit')->unsigned();
            $column->string('sick_off')->nullable();
            $column->date('sick_off_review')->nullable();
            $column->date('next_appointment')->nullable();
            //next steps
            $column->boolean('call')->default(false);
            $column->boolean('pre_authorization')->default(false);
            $column->boolean('book_theatre')->default(false);
            $column->boolean('refer_specialist')->default(false);
            $column->boolean('book_for_doctor')->default(false);
            $column->integer('user')->unsigned()->nullable();
            $column->timestamps();

            $column->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $column->foreign('visit')
                    ->references('id')
                    ->on('evaluation_visits')
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
        Schema::drop('evaluation_visit_metas');
    }

}

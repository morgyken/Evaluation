<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_procedures', function(Blueprint $column) {
            $column->increments('id');
            $column->string('name');
            $column->string('code'); //->unique();
            $column->integer('category')->unsigned();
            $column->integer('template')->unsigned()->nullable();
            $column->decimal('cash_charge', 10, 2); //cash amount charged
            $column->boolean('charge_insurance')->default(false); //cash charge applies to insurance
            $column->text('description')->nullable();
            $column->boolean('status')->default(true);
            $column->foreign('template')
                    ->references('id')
                    ->on('evaluation_procedure_templates')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $column->foreign('category')
                    ->references('id')
                    ->on('evaluation_procedure_categories')
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
        Schema::drop('evaluation_procedures');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureCategoryTemplatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_procedure_category_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category')->unsigned();
            $table->text('template');
            $table->timestamps();

            $table->foreign('category')
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
        Schema::dropIfExists('evaluation_procedure_category_templates');
    }

}

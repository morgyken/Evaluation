<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationSubproceduresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_subprocedures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procedure')->unsigned();
            $table->integer('parent')->nullable()->unsigned();
            $table->integer('category')->unsigned();
            $table->string('lab_sample_type')->nullable();
            $table->string('lab_result_type')->nullable();
            $table->string('lab_result_options')->nullable();
            $table->float('lab_min_range')->nullable();
            $table->float('lab_max_range')->nullable();
            $table->boolean('lab_default')->nullable()->default(true);
            $table->boolean('lab_ordered_independently')->nullable()->default(false);
            $table->boolean('lab_multiple_orders_allowed')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('procedure')
                    ->references('id')
                    ->on('evaluation_procedures')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('category')
                    ->references('id')
                    ->on('evaluation_labtest_categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('parent')
                    ->references('id')
                    ->on('evaluation_procedures')
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
        Schema::dropIfExists('evaluation_subprocedures');
    }

}

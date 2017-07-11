<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollectionMethodToEvaluationSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_samples', function (Blueprint $table) {
            $table->integer('collection_method_id')->unsigned()->nullable();
            $table->foreign('collection_method_id')
                ->references('id')
                ->on('evaluation_sample_collection_methods')
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
        Schema::table('evaluation_samples', function (Blueprint $table) {

        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEvaluationTemplatesLabTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_templates_lab', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('procedure')->unsigned();
            $table->integer('title')->unsigned()->nullable();
            $table->integer('subtest')->unsigned();
            $table->integer('sort_order')->nullable();

            $table->float('lab_min_range')->nullable();
            $table->float('lab_max_range')->nullable();

            $table->float('_0_3d_minrange')->nullable();
            $table->float('_0_3d_maxrange')->nullable();

            $table->float('_4_30d_minrange')->nullable();
            $table->float('_4_30d_maxrange')->nullable();

            $table->float('_1_24m_minrange')->nullable();
            $table->float('_1_24m_maxrange')->nullable();

            $table->float('_25_60m_minrange')->nullable();
            $table->float('_25_60m_maxrange')->nullable();

            $table->float('_5_19y_minrange')->nullable();
            $table->float('_5_19y_maxrange')->nullable();

            $table->float('adult_minrange')->nullable();
            $table->float('adult_maxrange')->nullable();
            $table->timestamps();

            $table->foreign('procedure')
                    ->references('id')
                    ->on('evaluation_procedures')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('subtest')
                    ->references('id')
                    ->on('evaluation_procedures')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('title')
                    ->references('id')
                    ->on('hemogram_titles')
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
        Schema::dropIfExists('evaluation_templates_lab');
    }

}

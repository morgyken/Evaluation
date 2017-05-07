<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProcedureToEvaluationProcedureTemplatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('evaluation_procedure_templates', function (Blueprint $table) {
            $table->integer('procedure')
                    ->unsigned()
                    ->after('id');

            $table->foreign('procedure')
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
        Schema::table('evaluation_procedure_templates', function (Blueprint $table) {

        });
    }

}

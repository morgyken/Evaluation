<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProcedureToHemogramTitlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('hemogram_titles', function (Blueprint $table) {
            $table->integer('procedure')
                    ->unsigned()
                    ->after('name')
                    ->nullable();

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
        Schema::table('hemogram_titles', function (Blueprint $table) {

        });
    }

}

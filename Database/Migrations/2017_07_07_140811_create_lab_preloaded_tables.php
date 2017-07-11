<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabPreloadedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_lab_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('evaluation_lab_specimen_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('evaluation_lab_additives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('evaluation_lab_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('evaluation_sample_collection_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists([
            'evaluation_lab_method_details',
            'evaluation_lab_departments',
            'evaluation_lab_additives',
            'evaluation_lab_specimen_types',
            'evaluation_lab_units'
        ]);
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountToInvestigationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('evaluation_investigations', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->after('procedure');
            $table->double('discount', 10, 2)->nullable()->after('price');
            $table->double('amount', 10, 2)->nullable()->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('evaluation_investigations', function (Blueprint $table) {

        });
    }

}

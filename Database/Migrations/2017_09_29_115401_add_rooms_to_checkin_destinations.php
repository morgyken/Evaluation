<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoomsToCheckinDestinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_visit_destinations', function (Blueprint $table) {
            $table->unsignedInteger('room_id')->nullable()->after('destination');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_visit_destinations', function ($table) {
            $table->dropColumn('room_id');
        });
    }
}

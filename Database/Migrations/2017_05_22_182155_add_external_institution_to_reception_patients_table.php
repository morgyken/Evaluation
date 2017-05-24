<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalInstitutionToReceptionPatientsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('reception_patients', function (Blueprint $table) {
            $table->integer('external_institution')->nullable()->unsigned();

            $table->foreign('external_institution')
                    ->references('id')
                    ->on('evaluation_lab_partner_institutions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('reception_patients', function (Blueprint $table) {
            $table->dropColumn('external_institution');
        });
    }

}

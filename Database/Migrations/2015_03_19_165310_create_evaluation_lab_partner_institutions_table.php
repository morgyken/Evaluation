<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationLabPartnerInstitutionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_lab_partner_institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('post_code')->nullable();
            $table->string('town');
            $table->string('street')->nulllable();
            $table->string('building')->nulllable();
            $table->string('telephone')->nullable();
            $table->string('mobile');
            $table->string('fax')->nullable();
            $table->string('email');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('evaluation_lab_partner_institutions');
    }

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tclient_temp', function (Blueprint $table) {
            $table->id();
            $table->string('client_id', 50);
            $table->string('instansi_name', 150)->nullable();
            $table->string('application_name', 150)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('country_id', 25)->nullable();
            $table->string('provinsi_id', 25)->nullable();
            $table->string('kabupaten_id', 25)->nullable();
            $table->string('kecamatan_id', 25)->nullable();
            $table->string('kelurahan_id', 25)->nullable();
            $table->string('kodepos', 25)->nullable();
            $table->string('npwp', 25)->nullable();
            $table->string('pers_responsible', 50)->nullable();
            $table->string('pos_pers_responsible', 50)->nullable();
            $table->string('mou_sign_name', 50)->nullable();
            $table->string('pos_sign_name', 50)->nullable();
            $table->string('administrator_name', 50)->nullable();
            $table->string('administrator_phone', 50)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('logo_small', 255)->nullable();
            $table->string('company_id', 50)->nullable();
            $table->string('web_add', 50)->nullable();
            $table->string('agreement', 1)->default('N');
            $table->string('client_category', 50)->nullable();
            $table->string('client_level', 50)->nullable();
            $table->string('flag_appr', 1)->default('N');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tclient_temp');
    }
};

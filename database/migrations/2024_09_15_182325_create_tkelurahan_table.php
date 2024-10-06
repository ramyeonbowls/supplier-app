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
        Schema::create('tkelurahan', function (Blueprint $table) {
            $table->string('provinsi_id', 100);
            $table->string('kabupaten_id', 100);
            $table->string('kecamatan_id', 100);
            $table->string('kelurahan_id', 100);
            $table->string('kelurahan_name', 255)->nullable();
            $table->string('postal_code', 100)->nullable();
            $table->timestamps();

            $table->primary(['provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tkelurahan');
    }
};

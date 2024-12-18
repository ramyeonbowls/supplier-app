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
        Schema::table('tclient', function (Blueprint $table) {
            $table->renameColumn('negara_id', 'country_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tclient', function (Blueprint $table) {
            $table->renameColumn('country_id', 'negara_id');
        });
    }
};

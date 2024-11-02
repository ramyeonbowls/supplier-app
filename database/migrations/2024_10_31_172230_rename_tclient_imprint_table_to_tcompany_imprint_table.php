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
        Schema::rename('tclient_imprint', 'tcompany_imprint');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('tcompany_imprint', 'tclient_imprint');
    }
};

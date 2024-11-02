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
        Schema::rename('tclient_bank_account', 'tcompany_bank_account');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('tcompany_bank_account', 'tclient_bank_account');
    }
};

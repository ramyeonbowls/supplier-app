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
        Schema::create('tclient_bank_account', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('npwp', 50);
            $table->string('account_bank', 50)->default('');
            $table->string('bank', 50)->default('');
            $table->string('account_name', 50)->default('');
            $table->string('bank_city', 50)->default('');
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by', 50)->default('');
            $table->timestamp('updated_at')->useCurrent();
            $table->string('updated_by', 50)->default('');

            $table->primary(['client_id', 'npwp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tclient_bank_account');
    }
};

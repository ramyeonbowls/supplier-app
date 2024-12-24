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
        Schema::table('tpo_paid_off', function (Blueprint $table) {
            $table->string('payment_image', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tpo_paid_off', function (Blueprint $table) {
            $table->string('payment_image', 100)->change();
        });
    }
};

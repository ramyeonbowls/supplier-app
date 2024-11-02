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
        Schema::create('browser_session_logs', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20);
            $table->ipAddress('visitor');
            $table->string('platform', 40);
            $table->string('device', 40);
            $table->string('browser', 60);
            $table->string('browser_name', 60);
            $table->string('country', 100)->default('');
            $table->string('city', 100)->default('');
            $table->string('user_agent');
            $table->timestamps();

            $table->index(['username', 'visitor', 'platform', 'device', 'browser'], 'idx_browser_session_logs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('browser_session_logs');
    }
};

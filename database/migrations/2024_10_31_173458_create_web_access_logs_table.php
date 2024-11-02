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
        Schema::create('web_access_logs', function (Blueprint $table) {
            $table->id();
            $table->string('access_uid', 20)->default('');
            $table->unsignedBigInteger('access_mid')->default(0);
            $table->string('access_url')->default('');
            $table->text('access_qstring');
            $table->string('access_ip', 45)->default('');
            $table->string('method', 10)->default('GET');
            $table->timestamp('access_date')->useCurrent();
            $table->dateTime('leave_date')->nullable($value = true);

            $table->index(['access_uid', 'access_mid', 'leave_date'], 'idx_web_access_logs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_access_logs');
    }
};

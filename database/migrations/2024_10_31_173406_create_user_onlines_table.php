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
        Schema::create('user_onlines', function (Blueprint $table) {
            $table->string('username', 20);
            $table->boolean('online')->default(false);
            $table->string('status', 100)->default('');
            $table->timestamp('last_online')->nullable();
            $table->timestamps();

            $table->primary(['username'], 'pk_user_onlines');
            $table->index(['username', 'online'], 'idx_user_onlines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_onlines');
    }
};

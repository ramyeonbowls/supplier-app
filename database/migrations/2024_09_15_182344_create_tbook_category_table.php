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
        Schema::create('tbook_category', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('description', 100);
            $table->dateTime('createdate')->nullable();
            $table->string('createby', 50)->nullable();
            $table->dateTime('updatedate')->nullable();
            $table->string('updateby', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbook_category');
    }
};

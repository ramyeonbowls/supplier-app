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
        Schema::create('tmapping_book', function (Blueprint $table) {
            $table->string('client_id');
            $table->string('po_number');
            $table->string('book_id', 50);
            $table->integer('copy')->nullable();
            $table->timestamps();

            $table->primary(['client_id', 'po_number', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmapping_book');
    }
};

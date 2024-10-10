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
        Schema::create('tclient_authorizing', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('author_id', 50);
            $table->string('author_desc', 50)->default('');
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by', 50)->default('');
            $table->timestamp('updated_at')->useCurrent();
            $table->string('updated_by', 50)->default('');

            $table->primary(['client_id', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tclient_authorizing');
    }
};

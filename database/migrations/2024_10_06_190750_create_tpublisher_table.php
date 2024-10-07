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
        Schema::create('tpublisher', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('id', 25);
            $table->string('description', 100)->nullable();
            $table->timestamps();

            $table->primary(['client_id', 'id'], 'pk__tpublisher');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpublisher');
    }
};

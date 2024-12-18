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
        Schema::create('tpo_header', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('po_number', 50);
            $table->date('po_date');
            $table->string('po_type', 1);
            $table->float('po_amount')->nullable();
            $table->float('po_discount')->nullable();
            $table->string('status', 1)->default('1');
            $table->datetime('created_at')->nullable();
            $table->string('created_by', 150)->nullable();

			$table->primary(['client_id', 'po_number', 'po_date'], 'PK_tpo_header');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpo_header');
    }
};

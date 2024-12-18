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
        Schema::create('tpo_detail', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('po_number', 50);
            $table->date('po_date');
            $table->string('book_id', 50);
            $table->integer('qty')->nullable();
            $table->float('sellprice')->nullable();
            $table->datetime('created_at')->nullable();
            $table->string('created_by', 150)->nullable();

			$table->primary(['client_id', 'po_number', 'po_date', 'book_id'], 'PK_tpo_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpo_detail');
    }
};

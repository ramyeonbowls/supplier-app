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
        Schema::create('tpo_paid_off', function (Blueprint $table) {
            $table->string('supplier_id', 50);
            $table->string('client_id', 50);
            $table->string('po_number', 50);
            $table->date('po_date');
            $table->string('status', 1)->default('');
            $table->string('payment_image', 100)->default('');
            $table->datetime('created_at')->nullable();
            $table->string('created_by', 150)->nullable();
            
            $table->primary(['supplier_id', 'client_id', 'po_number', 'po_date'], 'pk_tpo_paid_off');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tpo_paid_off');
    }
};

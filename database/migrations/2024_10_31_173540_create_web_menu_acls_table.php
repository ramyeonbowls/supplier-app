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
        Schema::create('web_menu_acls', function (Blueprint $table) {
            $table->string('username', 20);
            $table->unsignedBigInteger('menu_id');
            $table->boolean('create_permission')->default(true);
            $table->boolean('read_permission')->default(true);
            $table->boolean('update_permission')->default(true);
            $table->boolean('delete_permission')->default(true);
            $table->boolean('print_permission')->default(false);
            $table->boolean('approve_permission')->default(false);
            $table->timestamps();

            $table->primary(['username', 'menu_id'], 'pk_web_menu_acls');
            $table->index(['username', 'menu_id'], 'idx_web_menu_acls');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_menu_acls');
    }
};

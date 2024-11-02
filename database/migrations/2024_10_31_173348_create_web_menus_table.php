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
        Schema::create('web_menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('previd')->default(0);
            $table->string('menu_fn', 50)->default('');
            $table->string('menu_link', 1)->default('');
            $table->string('menu_label', 100)->default('');
            $table->string('menu_desc', 200)->default('');
            $table->tinyInteger('menu_seq')->default(1);
            $table->boolean('menu_visible')->default(true);
            $table->string('permission', 4)->default('rw')->comment('(rwpa) => r = read or rw = read-write or p = print or a = approve');
            $table->string('menu_icon', 100)->default('');
            $table->timestamps();

            $table->index(['id', 'previd', 'menu_fn', 'menu_visible', 'permission'], 'idx_web_menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_menus');
    }
};

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
        Schema::create('tvideo_draft', function (Blueprint $table) {
            $table->string('book_id', 50)->primary();
            $table->string('supplier_id', 50)->nullable();
            $table->string('isbn', 50)->nullable();
            $table->string('eisbn', 50)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('writer', 50)->nullable();
            $table->string('publisher_id', 25)->nullable();
            $table->integer('size')->nullable();
            $table->string('year', 4)->nullable();
            $table->integer('volume')->nullable();
            $table->integer('edition')->nullable();
            $table->integer('page')->nullable();
            $table->text('sinopsis')->nullable();
            $table->float('sellprice')->nullable();
            $table->float('rentprice')->nullable();
            $table->float('retailprice')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('category_id', 50)->nullable();
            $table->string('book_format_id', 25)->nullable();
            $table->string('filename', 100)->nullable();
            $table->string('cover', 200)->nullable();
            $table->integer('age')->nullable();
            $table->string('status', 1)->nullable();
            $table->string('reason', 150)->nullable();
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
        Schema::dropIfExists('tvideo_draft');
    }
};

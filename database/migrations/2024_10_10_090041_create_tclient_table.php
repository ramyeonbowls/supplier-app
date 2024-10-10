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
        Schema::create('tclient', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100); 
            $table->string('email', 100);
            $table->string('country', 50); 
            $table->string('province', 50); 
            $table->string('regency', 50); 
            $table->string('district', 50); 
            $table->string('subdistrict', 50); 
            $table->string('postal_code', 20);
            $table->string('address', 150);
            $table->string('telephone', 20);
            $table->string('handphone', 20);
            $table->string('director', 50);
            $table->string('position', 50);
            $table->string('handphone_director', 50);
            $table->string('pic', 50);
            $table->string('handphone_pic', 50);
            $table->string('file', 150)->default('');
            $table->string('agreement', 1)->default('N');
            $table->string('type', 1)->default('1');
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by', 50)->default('');
            $table->timestamp('updated_at')->useCurrent();
            $table->string('updated_by', 50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tclient');
    }
};

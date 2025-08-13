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
        Schema::create('capture_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analytic_id')
                  ->constrained('analytics')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('image_path')->nullable(); 
            $table->dateTime('capture_time'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capture_histories');
    }
};

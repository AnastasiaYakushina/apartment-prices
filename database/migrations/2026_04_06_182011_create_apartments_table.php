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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->integer('initial_price')->nullable();
            $table->string('url')->unique();
            $table->unsignedTinyInteger('rooms_count');
            $table->decimal('area', 8, 2);
            $table->string('developer');
            $table->string('complex');
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};

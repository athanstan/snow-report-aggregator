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
        Schema::create('snow_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->string('status')->default('default');
            $table->integer('open_lifts')->nullable();
            $table->integer('total_lifts')->nullable();
            $table->integer('base_snow')->nullable();
            $table->integer('mid_snow')->nullable();
            $table->integer('top_snow')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snow_reports');
    }
};

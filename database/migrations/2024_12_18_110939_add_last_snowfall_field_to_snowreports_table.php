<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('snow_reports', function (Blueprint $table) {
            $table->string('last_snowfall')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('snow_reports', function (Blueprint $table) {
            $table->dropColumn('last_snowfall');
        });
    }
};
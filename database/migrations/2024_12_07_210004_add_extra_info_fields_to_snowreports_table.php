<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('snow_reports', function (Blueprint $table) {
            $table->string('snow_quality')->nullable();
            $table->string('weather_conditions')->nullable();
            $table->string('google_maps')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('snow_reports', function (Blueprint $table) {
            $table->dropColumn('snow_quality');
            $table->dropColumn('weather_conditions');
            $table->dropColumn('google_maps');
        });
    }
};

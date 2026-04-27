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
        // KPI Points Log
        Schema::create('kpi_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('points_change');
            $table->string('reason');
            $table->string('category'); // Attendance, Punctuality, Profit, etc
            $table->timestamps();
        });

        // Badges Master
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon'); // font-awesome icon name
            $table->string('color')->default('#fbbf24');
            $table->string('description');
            $table->string('requirement_type'); // e.g. zero_complain, target_revenue
            $table->integer('requirement_value');
            $table->timestamps();
        });

        // User Badges
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('badge_id')->constrained('badges')->onDelete('cascade');
            $table->timestamp('awarded_at');
            $table->timestamps();
        });

        // KPI Settings (Weights)
        Schema::create('kpi_settings', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('metric_name');
            $table->integer('weight'); // percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_settings');
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('kpi_logs');
    }
};

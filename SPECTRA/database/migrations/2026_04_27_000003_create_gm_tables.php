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
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_line')->nullable(); // Bangunan, Bengkel, Entertainment, Antrian
            $table->integer('kpi_points')->default(0);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('contract_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('contract_file');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['business_line', 'kpi_points']);
        });
    }
};

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
            $table->string('area')->nullable(); // Semarang, Bandung, etc
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_name');
            $table->enum('service_type', ['Bangunan', 'Bengkel', 'Entertainment', 'Antrian']);
            $table->decimal('contract_value', 15, 2);
            $table->string('duration');
            $table->text('details')->nullable();
            $table->string('area');
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade'); // Manager Area
            $table->enum('status', ['active', 'completed', 'pending'])->default('active');
            $table->timestamps();
        });

        Schema::table('daily_reports', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::table('daily_reports', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::dropIfExists('projects');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('area');
        });
    }
};

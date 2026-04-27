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
            $table->string('role')->default('korlap'); // korlap, admin, director, etc
            $table->string('photo_profile')->nullable();
            $table->string('phone')->nullable();
        });

        // Attendances Table
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The person being recorded
            $table->foreignId('korlap_id')->constrained('users')->onDelete('cascade'); // The korlap who records it
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa']);
            $table->string('photo')->nullable();
            $table->string('location_lat')->nullable();
            $table->string('location_long')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Daily Reports Table
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Korlap
            $table->text('progress');
            $table->text('obstacles')->nullable();
            $table->string('photo'); // Mandatory
            $table->timestamps();
        });

        // Installation Reports Table (Entertainment)
        Schema::create('installation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Korlap
            $table->string('unit_number');
            $table->string('signal_strength');
            $table->string('photo');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Salaries / Payouts Table
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('type')->default('gaji'); // gaji, bagi_hasil
            $table->enum('status', ['pending', 'paid'])->default('paid');
            $table->date('payment_date');
            $table->timestamps();
        });

        // Directors Profile Table
        Schema::create('directors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directors');
        Schema::dropIfExists('salaries');
        Schema::dropIfExists('installation_reports');
        Schema::dropIfExists('daily_reports');
        Schema::dropIfExists('attendances');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'photo_profile', 'phone']);
        });
    }
};

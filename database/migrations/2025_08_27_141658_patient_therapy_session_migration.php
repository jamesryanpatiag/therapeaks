<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create the 'patients' table
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
        // Create the 'sessions' table to track therapy sessions
        Schema::create('therapy_sessions', function (Blueprint $table) {
            $table->id();

            // Foreign key for the patient
            $table->foreignId('patient_id')
                  ->constrained() // This automatically uses the 'patients' table
                  ->onDelete('cascade'); // Delete sessions if the patient is deleted

            // Foreign key for the therapist
            $table->foreignId('user_id')
                  ->constrained() // This automatically uses the 'therapists' table
                  ->onDelete('cascade'); // Delete sessions if the therapist is deleted

            $table->dateTime('session_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method is used to roll back the migrations. The tables
     * must be dropped in the correct order to avoid foreign key errors.
     * The dependent table ('sessions') must be dropped first.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

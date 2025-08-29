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
        Schema::create('treatment_chat_per_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                  ->constrained() // This automatically uses the 'patients' table
                  ->onDelete('cascade'); // Delete sessions if the patient is deleted

            $table->foreignId('user_id')
                  ->constrained() // This automatically uses the 'therapists' table
                  ->onDelete('cascade'); // Delete sessions if the therapist is deleted
                
            $table->text('message');
            $table->text('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_chat_per_patients');
    }
};

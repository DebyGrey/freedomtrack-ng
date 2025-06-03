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
        Schema::create('inmate_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inmate_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'completed', 'dropped'])->default('active');
            $table->decimal('progress',6, 3); // 0-100 percentage
            $table->date('enrollment_date');
            $table->date('completion_date')->nullable();
            $table->string('certification')->nullable(); // Certification received upon completion
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure an inmate can only be enrolled once per program
            $table->unique(['inmate_id', 'program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inmate_program');
    }
};

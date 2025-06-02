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
        Schema::create('inmates', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('inmate_id')->unique();
            $table->string('name');
            $table->integer('age');
            $table->date('date_of_birth');
            $table->string('facility');
            $table->date('admission_date');
            $table->string('sentence');
            $table->date('sentence_end_date');
            $table->string('offense');
            $table->integer('readiness_score')->default(0);
            $table->boolean('is_parole_eligible')->default(false);
            $table->date('parole_date')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_relationship');
            $table->string('emergency_contact_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inmates');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();            
            $table->string('name', 255);       
            $table->date('dob');           
            $table->string('contact_number', 15)->nullable();
            $table->string('contact_person', 255)->nullable();
            $table->string('student_relation', 255)->nullable();
            $table->string('seat_type', 255);
            $table->double('donation')->nullable(); // Donation amount.
            $table->bigInteger('referred_by')->nullable(); // Foreign key to User with management role
            $table->string('admission_no')->unique();
            $table->bigInteger('course_id'); // Foreign key to the Course model
            $table->bigInteger('batch_id'); // Foreign key to the Batch model
            $table->bigInteger('department_id'); // Foreign key to the Department model
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

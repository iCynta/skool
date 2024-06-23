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
        Schema::create('students', function (Blueprint $table) {
            $table->id();            
            $table->string('name', 255)->index();       
            $table->date('dob')->index();           
            $table->string('contact_number', 15)->nullable()->index();
            $table->string('contact_person', 255)->nullable();
            $table->string('student_relation', 255)->nullable();
            $table->string('seat_type', 255);
            $table->double('donation')->nullable(); // Donation amount.
            $table->unsignedBigInteger('referred_by')->nullable()->index(); // Foreign key to User with management role
            $table->string('admission_no')->unique();
            $table->unsignedBigInteger('course_id')->index(); // Foreign key to the Course model
            $table->unsignedBigInteger('batch_id')->index(); // Foreign key to the Batch model
            $table->unsignedBigInteger('department_id')->index(); // Foreign key to the Department model
            $table->softDeletes();
            $table->timestamps();

            // Adding foreign key constraints
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

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
        Schema::create('students_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Student ID
            $table->string('reciept_no', 191)->nullable(); // Make receipt_no nullable
            $table->unsignedBigInteger('expense_id'); // Expense ID
            $table->decimal('amount', 10, 2); // Amount with 2 decimal places
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_expenses');
    }
};

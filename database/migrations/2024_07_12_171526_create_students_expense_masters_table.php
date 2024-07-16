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
        Schema::create('students_expense_masters', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->string('expense_name', 100); // VARCHAR 100
            $table->dateTime('created_at'); // DateTime
            $table->integer('status')->default(0); // Integer with default value 0
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_expense_masters');
    }
};


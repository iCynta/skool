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
        Schema::create('employee_expense_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();

            // Add indexes
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_expense_masters');
    }
};

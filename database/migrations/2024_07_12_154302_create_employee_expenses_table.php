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
        Schema::create('employee_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no', 20)->unique();
            $table->text('description');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('expense_id');
            $table->unsignedBigInteger('created_by');
            $table->decimal('amount', 8, 2);
            $table->boolean('settled')->default(false);
            $table->softDeletes();
            $table->timestamps();

            // Add indexes
            $table->index('employee_id');
            $table->index('expense_id');
            $table->index('created_by');
            $table->index('deleted_at');

            // Add foreign key constraints
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('expense_id')->references('id')->on('employee_expense_masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_expenses', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['expense_id']);
        });

        Schema::dropIfExists('employee_expenses');
    }
};

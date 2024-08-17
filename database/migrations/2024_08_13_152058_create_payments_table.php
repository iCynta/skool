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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paid_by')->constrained('users')->onDelete('cascade');
        
            // Payment type (e.g., User, Bank, etc.)
            $table->string('payment_type', 100);
            $table->foreignId('paid_to')->nullable()->constrained('users')->onDelete('set null');
        
            // Payment detail
            $table->string('detail')->nullable();
            
            // Payment slip (assumed to be a string, possibly a file path)
            $table->string('payment_slip')->nullable();
            
            // JSON field to store selected payments
            $table->json('selected_payments')->nullable();

            $table->dateTime('paid_date');
            
            // Soft deletes
            $table->softDeletes();
            
            // Timestamps
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

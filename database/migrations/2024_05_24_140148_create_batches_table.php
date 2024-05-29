<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20); // Assuming code length is 20
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('name', 255);
            $table->integer('merit_seat');
            $table->integer('payment_seat');
            $table->decimal('tution_fee', 8, 2); // Added precision and scale to the decimal
            $table->date('start_date');
            $table->unsignedTinyInteger('course_tenure'); // Course tenure in months
            $table->softDeletes(); // Adds the deleted_at column
            $table->timestamps();

            $table->unique('code', 'batches_code_unique'); // Specifying unique key name explicitly
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};

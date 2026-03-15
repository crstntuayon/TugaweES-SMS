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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to student
            $table->foreignId('student_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->comment('Student who received the book');
            
            // Book identification
            $table->string('title')
                  ->comment('Title of the textbook or learning material');
            
            $table->string('subject_area')
                  ->nullable()
                  ->comment('Subject area (e.g., Math, Science, English)');
            
            $table->string('book_code')
                  ->nullable()
                  ->comment('Internal book tracking code');
            
            $table->string('reference_code')
                  ->nullable()
                  ->comment('ISBN or official reference number');
            
            // Dates
            $table->date('date_issued')
                  ->nullable()
                  ->comment('Date when book was issued to student');
            
            $table->date('date_returned')
                  ->nullable()
                  ->comment('Date when book was returned');
            
            // Status tracking
            $table->enum('status', ['issued', 'returned', 'lost'])
                  ->default('issued')
                  ->comment('Current status of the book');
            
            $table->enum('condition', ['new', 'good', 'fair', 'damaged', 'poor'])
                  ->nullable()
                  ->comment('Physical condition of the book');
            
            $table->text('damage_details')
                  ->nullable()
                  ->comment('Description of damage if applicable');
            
            // Loss reporting codes (per DepEd guidelines)
            $table->enum('loss_code', ['FM', 'TDO', 'NEG'])
                  ->nullable()
                  ->comment('FM=Force Majeure, TDO=Transferred/Dropout, NEG=Negligence');
            
            $table->enum('action_taken', ['LLTR', 'TLTR', 'PTL'])
                  ->nullable()
                  ->comment('LLTR=Letter from Learner, TLTR=Teacher Letter, PTL=Paid');
            
            $table->text('remarks')
                  ->nullable()
                  ->comment('Additional notes or comments');
            
            // Audit timestamps
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index('student_id');
            $table->index('status');
            $table->index('subject_area');
            $table->index(['student_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
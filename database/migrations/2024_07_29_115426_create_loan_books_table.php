<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('member_id');
            $table->decimal('price', 8, 2);
            $table->date('loan_date');
            $table->date('due_date');
            $table->string('invoice_number')->unique();
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
            $table->date('renew_date')->nullable();
            $table->date('pay_date')->nullable();
            $table->decimal('fine', 8, 2)->nullable()->default(0);
            $table->text('fine_reason')->nullable();
            $table->timestamps();
            
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_books');
    }
};

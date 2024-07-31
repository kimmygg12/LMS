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
        Schema::create('loan_book_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('member_id');
            $table->decimal('price', 8, 2);
            $table->date('loan_date');
            $table->string('invoice_number');
            $table->date('renew_date')->nullable();
            $table->date('pay_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('fine', 8, 2)->nullable();
            $table->text('fine_reason')->nullable();
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed')->nullable();
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
        Schema::dropIfExists('loan_book_histories');
    }
};

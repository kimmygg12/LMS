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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('title');
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->string('isbn')->unique();
            $table->date('publication_date')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('set null'); // Foreign key
            $table->string('cover_image')->nullable();
            $table->enum('status', ['available', 'borrowed', 'reserved', 'deleted'])->default('available');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};

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
            $table->string('isbn')->unique();
            $table->date('publication_date')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('genre_id')->nullable()->constrained('genres')->onDelete('set null');
            $table->string('cover_image')->nullable();
            $table->enum('status', ['available', 'borrowed', 'reserved','unavailable', 'deleted'])->default('available');
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

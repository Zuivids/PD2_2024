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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producer_id');
            $table->string('name', 256);
            $table->text('description')->nullable();
            //TODO change price to raiting
            // $table->decimal('price', 8, 2)->nullable();
            $table->foreignId('genre_id');
            $table->integer('rating');
            $table->integer('year');
            $table->string('image', 256)->nullable();
            $table->boolean('display');
            $table->timestamps();
            $table->foreign('producer_id')->references('id')->on('producers');
            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};

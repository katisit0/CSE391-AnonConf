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
        Schema::create('confessions', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->unsignedBigInteger('mood_id');
            $table->unsignedBigInteger('user_id')->nullable();
        
            $table->integer('upvotes')->default(0);
            $table->integer('reports')->default(0);
        
            $table->timestamps();
            $table->softDeletes();
        
            $table->foreign('mood_id')->references('id')->on('moods')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('confessions');
    }

};

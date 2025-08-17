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
        Schema::create('confession_upvotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('confession_id')->constrained()->onDelete('cascade');
            $table->ipAddress('ip_address');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confession_upvotes');
    }

};

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
        Schema::create('confession_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('confession_id')->constrained()->onDelete('cascade');
            $table->ipAddress('ip_address');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confession_reports');
    }

};

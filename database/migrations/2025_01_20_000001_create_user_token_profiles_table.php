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
        Schema::create('user_token_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('user_type', ['casual', 'frequent', 'power'])->default('casual');
            $table->integer('monthly_token_limit')->default(50000);
            $table->integer('monthly_cost_limit')->default(75); // in cents
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_usage_reset')->nullable();
            $table->timestamps();
            
            $table->unique('user_id');
            $table->index(['user_type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_token_profiles');
    }
}; 
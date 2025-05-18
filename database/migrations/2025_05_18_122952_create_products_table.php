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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('code')->nullable();
            $table->json('slug');
            $table->json('slogan')->nullable();
            $table->json('content')->nullable();

            $table->boolean('status')->default(true)->index();
            $table->unsignedTinyInteger('gender')->default(0)->index();
            $table->decimal('price', 10, 2)->default(0)->index();
            $table->decimal('old_price', 10, 2)->default(0)->index();
            $table->unsignedInteger('count')->default(0)->index();
            $table->unsignedInteger('percent')->default(0)->index();
            $table->unsignedInteger('position')->default(0)->index();

            $table->boolean('is_new')->default(false)->index();
            $table->boolean('is_home_top')->default(false)->index();
            $table->boolean('is_home_sale')->default(false)->index();
            $table->boolean('is_page_sale')->default(false)->index();

            $table->string('src')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();

            $table->boolean('lens')->default(false)->index();

            // Left eye fields
            $table->boolean('left')->default(false)->index();
            $table->string('left_power')->nullable()->index();
            $table->string('left_cylinder')->nullable()->index();
            $table->string('left_axis')->nullable()->index();
            $table->string('left_base_curve')->nullable()->index();
            $table->string('left_color')->nullable()->index();
            $table->unsignedInteger('left_count')->nullable()->index();

            // Right eye fields
            $table->boolean('right')->default(false)->index();
            $table->string('right_power')->nullable()->index();
            $table->string('right_cylinder')->nullable()->index();
            $table->string('right_axis')->nullable()->index();
            $table->string('right_base_curve')->nullable()->index();
            $table->string('right_color')->nullable()->index();
            $table->unsignedInteger('right_count')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

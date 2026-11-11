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
            $table->text('name');
            $table->longText('description');
            $table->integer('price')->default(0);
            $table->integer('stock')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
        
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('qty')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
        
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('qty')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('discount', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('discount')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('sales_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('discount_id')->constrained('discount')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('discount');
        Schema::dropIfExists('sales_discounts');
    }
};

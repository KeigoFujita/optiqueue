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
        Schema::create('product_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('movement_type');       // 'in', 'out', 'adjustment'
            $table->string('movement_category');    // e.g., 'purchase_order', 'sale', 'damage', etc.
            $table->integer('quantity');            // Always positive; direction determined by movement_type
            $table->date('movement_date');
            $table->string('reference_id')->nullable(); // Order #, PO #, transfer slip, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_movements');
    }
};

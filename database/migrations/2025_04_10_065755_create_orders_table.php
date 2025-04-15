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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->text('description')->nullable();
            $table->date('order_date')->nullable();
            $table->string('status')->default('pending');
            $table->string('order_type')->nullable();
            $table->string('cargo_description_type')->nullable();
    
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_gst')->nullable();
            $table->text('customer_address')->nullable();
    
            $table->unsignedBigInteger('consignor_id')->nullable();
            $table->string('consignor_gst')->nullable();
            $table->text('consignor_loading')->nullable();
    
            $table->unsignedBigInteger('consignee_id')->nullable();
            $table->string('consignee_gst')->nullable();
            $table->text('consignee_unloading')->nullable();
    
            $table->json('lr')->nullable(); // Nested LR array with cargo_description array inside
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

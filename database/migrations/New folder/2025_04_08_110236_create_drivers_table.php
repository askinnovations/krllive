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
        Schema::create('drivers', function (Blueprint $table) {
            
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('emergency_contact_number')->nullable();
            $table->text('address')->nullable();
            $table->string('state');
            $table->string('pin_code')->nullable();
            $table->string('aadhaar_number')->nullable();

            $table->string('vehicle_number')->nullable();
           
            $table->string('driver_photo')->nullable();
            $table->string('aadhaar_doc')->nullable();
            $table->string('license_doc')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};

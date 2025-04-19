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
        Schema::create('task_managements', function (Blueprint $table) {
            $table->id();
            $table->string('assigned_to'); // You can change to foreignId if linking with employees table
            $table->text('description');
            $table->boolean('high_priority')->default(false);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_managements');
    }
};

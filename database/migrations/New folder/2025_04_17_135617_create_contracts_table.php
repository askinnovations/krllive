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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate', 10, 2)->nullable(); // DECIMAL type with 10 digits and 2 decimal places

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
   {
    Schema::table('contracts', function (Blueprint $table) {
        $table->dropColumn('rate');
    });
   }
};

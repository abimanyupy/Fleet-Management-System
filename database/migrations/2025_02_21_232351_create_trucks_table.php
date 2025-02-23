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
        Schema::create('trucks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number_plate')->unique();
            $table->string('truck_capacity');
            // $table->string('hauling_max_speed');
            // $table->string('empty_max_speed');
            $table->string('fuel_capacity');
            // $table->string('fuel_consumption');
            $table->string('license_number')->unique();
            $table->date('created_date');
            $table->date('expired_date');
            $table->enum('license_status', ['active', 'need an update','expired'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};

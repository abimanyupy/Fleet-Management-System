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
        Schema::create('hauling_routes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('route_name'); //tambang A - Pelabuhan B rute 1, tambang A - Pelabuhan B rute 2
            $table->integer('length');
            $table->time('estimation_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hauling_routes');
    }
};

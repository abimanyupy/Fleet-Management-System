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
        Schema::create('truck_assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('driver_id')->constrained('drivers');
            $table->foreignUuid('truck_id')->constrained('trucks');
            $table->foreignUuid('hauling_route_id')->constrained('hauling_routes');
            $table->date('assignment_date');
            $table->time('deparature_time');
            $table->time('arrival_time')->nullable();
            $table->integer('cycle_time')->nullable();
            $table->enum('assignment_status',['ON PROGRESS', 'COMPLETE', 'PENDING'])->default('ON PROGRESS'); // ON PROGRESS, COMPLETE, CANCEL
            $table->integer('total_load');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_assignments');
    }
};

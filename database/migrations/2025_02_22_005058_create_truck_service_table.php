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
        Schema::create('truck_service', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('truck_id')->constrained('trucks');
            $table->string('service_description')->nullable();
            $table->enum('service_status', ['READY', 'NEED REPAIR', 'IN SERVICE','WARNING'])->default('IN SERVICE'); // READY, CAUTION, NEED REPAIR, IN_SERVICE,
            $table->boolean('is_serviced')->default(true); // YES, NO
            $table->date('start_service_date')->nullable();
            $table->date('finish_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_service');
    }
};

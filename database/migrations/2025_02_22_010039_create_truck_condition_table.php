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
        Schema::create('truck_condition', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('truck_id')->constrained('trucks');
            $table->string('damage_type');
            $table->boolean('is_resolved')->default(true); // YES, NO
            $table->datetime('record_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_condition');
    }
};

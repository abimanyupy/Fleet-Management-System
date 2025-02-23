<?php

namespace App\Models;

use App\Models\Trucks;
use App\Models\Drivers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FuelLog extends Model
{
    use HasUuids;

    protected $table = 'fuel_logs';

    protected $fillable = [
        'truck_id',
        'driver_id',
        'refuel_date',
        'liters_filled',
        'cost',
        'created_at',
        'updated_at',
    ];
    // protected $casts = [
    //     'refuel_date' => 'datetime',
    // ];

    public function trucks()
    {
        return $this->belongsTo(Trucks::class, 'truck_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'driver_id', 'id');
    }
}

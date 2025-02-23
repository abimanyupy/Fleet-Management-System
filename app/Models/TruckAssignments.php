<?php

namespace App\Models;

use App\Models\Trucks;
use App\Models\Drivers;
use App\Models\HaulingRoutes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TruckAssignments extends Model
{
     use HasUuids;

    protected $table = 'truck_assignments';

    protected $fillable = [
        'truck_id',
        'driver_id',
        'hauling_route_id',
        'road_id',
        'assignment_date',
        'deparature_time',
        'arrival_time',
        'cycle_time',
        'assignment_status',
        'total_load',
        'notes',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function trucks()
    {
        return $this->belongsTo(Trucks::class, 'truck_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'driver_id', 'id');
    }

    public function haulling_route()
    {
        return $this->belongsTo(HaulingRoutes::class, 'hauling_route_id', 'id');
    }

}

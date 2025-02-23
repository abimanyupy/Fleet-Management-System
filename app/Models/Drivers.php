<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Drivers extends Model
{
    use HasUuids;

    protected $table = 'drivers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'license_number',
        'driver_status',
    ];

    protected $attributes = [
        'driver_status' => 'active'
    ];


    function truck_assignments()
    {
        return $this->hasMany(TruckAssignments::class, 'driver_id', 'id');
    }

    function fuel_logs()
    {
        return $this->hasMany(FuelLog::class, 'driver_id', 'id');
    }
    
}

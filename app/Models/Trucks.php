<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Gps;
use App\Models\TruckService;
use App\Models\TruckCondition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Trucks extends Model
{
    use HasUuids;

    protected $table = 'trucks';

    protected $fillable = [
        'number_plate',
        'truck_capacity',
        // 'hauling_max_speed',
        // 'empty_max_speed',
        'fuel_capacity',
        // 'fuel_consumption',
        'license_number',
        'created_date',
        'expired_date',
        'license_status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // public function getExpiredDateAttribute($value) {
    //     return Carbon::parse($value)->format('d M Y');
    // }

    // public function getCreatedDateAttribute($value) {
    //     return Carbon::parse($value)->format('d M Y');
    // }

    function truck_assignments()
    {
        return $this->hasMany(TruckAssignments::class, 'truck_id', 'id');
    }

    function truck_services()
    {
        return $this->hasMany(TruckService::class, 'truck_id', 'id');
    }

    function truck_condition()
    {
        return $this->hasMany(TruckCondition::class, 'truck_id', 'id');
    }

    function gps()
    {
        return $this->hasOne(Gps::class, 'truck_id', 'id');
    }

}

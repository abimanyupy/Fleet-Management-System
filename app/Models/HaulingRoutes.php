<?php

namespace App\Models;

use App\Models\TruckAssignments;
use App\Models\HaulingRouteWeather;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class HaulingRoutes extends Model
{
    use HasUuids;

    protected $table = 'hauling_routes';

    protected $fillable = [
        'route_name',
        'length',
        'estimation_time',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function haulingRouteWeather()
    {
        return $this->hasMany(HaulingRouteWeather::class, 'route_id', 'id');
    }

    public function truck_assignments()
    {
        return $this->hasMany(TruckAssignments::class, 'hauling_route_id', 'id');
    }

    public function getFormattedEstimationTimeAttribute()
    {
        $timeParts = explode(':', $this->estimation_time);
        $hours = (int) $timeParts[0];
        $minutes = (int) $timeParts[1];

        $formattedTime = '';
        if ($hours > 0) {
            $formattedTime .= $hours . ' jam ';
        }
        if ($minutes > 0) {
            $formattedTime .= $minutes . ' menit';
        }

        return trim($formattedTime);
    }
}

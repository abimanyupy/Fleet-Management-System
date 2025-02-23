<?php

namespace App\Models;

use App\Models\HaulingRoutes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class HaulingRouteWeather extends Model
{
    use HasUuids;

    protected $table = 'hauling_route_weather';

    protected $fillable = [
        'route_id',
        'kilometer',
        'latitude',
        'longitude',
        'weather_condition',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function hauling_route() 
    {
        return $this->belongsTo(HaulingRoutes::class, 'route_id', 'id');
    }

}

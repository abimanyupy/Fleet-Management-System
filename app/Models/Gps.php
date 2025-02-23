<?php

namespace App\Models;

use App\Models\Trucks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Gps extends Model
{
    use HasUuids;

    protected $table = 'gps';

    protected $fillable = [
        'id',
        'latitude',
        'longitude',
        'truck_id',
        'device_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function trucks()
    {
        return $this->hasOne(Trucks::class, 'id', 'truck_id');
    }
}

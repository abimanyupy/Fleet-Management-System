<?php

namespace App\Models;

use App\Models\Trucks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TruckService extends Model
{
    use HasUuids;

    protected $table = 'truck_service';

    protected $fillable = [
        'truck_id',
        'service_description',
        'service_status',
        'is_serviced',
        'start_service_date',
        'finish_service_date',
        'next_service_date',
    ];

    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    // ];

    public function trucks()
    {
        return $this->belongsTo(Trucks::class, 'truck_id', 'id');
    }
}

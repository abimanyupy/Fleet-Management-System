<?php

namespace App\Models;

use App\Models\Trucks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TruckCondition extends Model
{
    use HasUuids;

    protected $table = 'truck_condition';

    protected $fillable = [
        'truck_id',
        'damage_type',
        'is_resolved',
        'record_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function trucks()
    {
        return $this->belongsTo(Trucks::class, 'truck_id', 'id');
    }
}

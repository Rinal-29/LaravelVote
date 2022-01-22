<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locations extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'open_time',
        'description',
        'facility',
    ];

    public function galleries()
    {
        return $this->hasMany(LocationsGallery::class, 'locations_id', 'id');
    }
}

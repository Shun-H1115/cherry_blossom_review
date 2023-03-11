<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Spot extends Model
{
    use HasFactory;

    protected $appends = ['map_url'];

    public function scopeSelectionDistance($query, $longitude, $latitude)
    {
        $query->selectRaw(
            'id, name, address, '.
            'ST_Y(location) AS longitude, ST_X(location) AS latitude, '.
            'st_distance_sphere(POINT(?, ?), POINT(ST_Y(location), ST_X(location)))',
            [ $longitude, $latitude,]
        );
    }

    public function getMapUrlAttribute()
    {
        return 'https://www.google.com/maps/search/?api=1&query='. $this->latitude .','. $this->longitude;
    }

    public function setLocationAttribute($values)
    {
        $point = 'POINT('. $values['latitude'] .' '. $values['longitude'] .')';
        $this->attributes['location'] = DB::raw('ST_GeomFromText("'. $point .'")');
    }
}

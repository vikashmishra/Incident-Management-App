<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    
    public $fillable = [
        'title',
        'location',
        'category',
        'people',
        'comments',
        'incident_time',
        'create_time',
        'update_time'
    ];
    
    public $timestamps  = false;
    
    public function getLocationAttribute($value)
    {
        return json_decode($value);
    }
    
    public function getPeopleAttribute($value)
    {
        return json_decode($value);
    }
}

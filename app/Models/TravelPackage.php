<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPackage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function gallerie()
    {
        return $this->hasOne(Gallery::class);
    }

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

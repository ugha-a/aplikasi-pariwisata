<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'locatinons';

    public function users()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}

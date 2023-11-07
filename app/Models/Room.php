<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'channel_id', 'capacity']; 
    public function sessions()
    {
        return $this->hasMany(Session::class, 'room_id', 'id');
        
    }
}

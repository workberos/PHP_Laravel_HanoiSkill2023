<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function organizer()
    {
        return $this->hasOne(Organizer::class, 'id', 'organizer_id');
        
    }

    public function tickets()
    {
        return $this->hasMany(Event_ticket::class, 'event_id', 'id');
    }

    public function channels()
    {
        return $this->hasMany(Channel::class, 'event_id', 'id');
    }
}

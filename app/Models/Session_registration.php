<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session_registration extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['registration_id', 'session_id'];
}

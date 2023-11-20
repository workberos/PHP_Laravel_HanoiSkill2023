<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['login_token'];
}

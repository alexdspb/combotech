<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // created_at will be maintained by Laravel
    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'status',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'company',
        'contract_type',
        'image',
        'is_closed'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Education extends Model
{
    protected $fillable = [
        'user_id',
        'school',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::saved(fn($model) => Cache::forget("user_profile_{$model->user_id}"));
        static::deleted(fn($model) => Cache::forget("user_profile_{$model->user_id}"));
    }
}

<?php

namespace App\Models;

use App\Http\Controllers\Api\UuidGenerater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'link'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
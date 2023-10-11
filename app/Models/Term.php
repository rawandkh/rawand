<?php

namespace App\Models;

use App\Http\Controllers\Api\UuidGenerater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function collage(): BelongsTo
    {
        return $this->belongsTo(Collage::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
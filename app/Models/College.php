<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class);
    }

    public function codes(): HasMany
    {
        return $this->hasMany(Code::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
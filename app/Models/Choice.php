<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_choices', 'choice_id')->withPivot('status');
    }
}
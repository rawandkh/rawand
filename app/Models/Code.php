<?php

namespace App\Models;

use App\Http\Controllers\Api\UuidGenerater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Code extends Authenticatable
{
    use HasFactory, HasApiTokens, HasRoles;

    protected $fillable = [
        'code',
        'college_id'
    ];
    protected $guard_name = 'web';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    // protected $casts = [
    //     'code' => 'hashed'
    // ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }
}
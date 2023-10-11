<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Report extends Model
{
    use HasFactory;
 protected $fillable=[
'content'
 ];
 public static function boot(){
    parent::boot();
    static::creating(function($model)
    {
$model->uuid=Uuid::uuid4()->toString();
    });
 }
 public function users(){
    return $this->belongsTo(User::class);
 }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'title',
        'level',
        'author'
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class,'author','id');
    }
}

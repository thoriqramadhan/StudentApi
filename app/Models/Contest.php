<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * Get the  that owns the Contest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'contest_id', 'id');
    }
}

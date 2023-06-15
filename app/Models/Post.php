<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'categories_id',
        'user_id'
    ];

    public function user_posts(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class,'categories_id','id');
    }
}

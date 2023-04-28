<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'category',
        'published'
    ];

    public function scopepublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeWhereCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Orion\Http\Controllers\Controller;

class PostsController extends Controller{

    protected $model = Post::class;

    // this for search api
    public function searchableBy(): array
    {
        return ['title', 'body', 'category'];
    }

    // this for filter api
    public function filterableBy(): array
    {
        return ['title', 'body', 'created_at', 'updated_at', 'published', 'id', 'category'];
    }

    // this for sort api
    public function sortableBy(): array
    {
        return ['title', 'category'];
    }
   
    // this for scope api
    public function exposedScopes(): array
    {
        return ['published', 'whereCategory'];
    }
}

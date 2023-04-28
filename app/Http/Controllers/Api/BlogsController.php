<?php

namespace App\Http\Controllers\Api;

use Orion\Http\Controllers\Controller;
use App\Models\Blog;

class BlogsController extends Controller{

    protected $model = Blog::class;
}
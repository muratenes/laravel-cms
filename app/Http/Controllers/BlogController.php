<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Repositories\Interfaces\BlogInterface;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private BlogInterface $_blogService;

    public function __construct(BlogInterface $blogService)
    {
        $this->_blogService = $blogService;
    }

    public function list()
    {
        $list = $this->_blogService->allWithPagination(['active' => 1]);
        return view('site.blog.listBlog', compact('list'));
    }

    public function detail(Blog $blog)
    {
        return view('site.blog.blogDetail', compact('blog'));
    }
}

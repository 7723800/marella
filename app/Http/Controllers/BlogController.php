<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index() 
    {
        $blogs = Blog::where('active', '=', 1)->orderBy('id', 'desc')->get();
        $data = array(
            'blogs' => $blogs,
            'page' => (object) array(
                'title' => 'Блог'
            )
        );
        return view('blog', compact('data'));
    }
}

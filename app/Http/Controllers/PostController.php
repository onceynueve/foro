<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
    	$posts=Post::orderBy('created_at','DESC')->paginate();
    	return view('posts.index',compact('posts'));
    }
    public function show(Post $post,$slug)
    {
		abort_if($post->slug!=$slug, 404);
		return view('posts.show',compact('post'));
	}
}

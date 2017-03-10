<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class CreatePostController extends Controller
{
    public function create()
    {
    	return view('posts.create');
    }

    public function store(Request $request)
    {
    	$this->validate($request,['title'=>'required','content'=>'required']);
    	$post=auth()->user()->createPost($request->all());
    	return redirect($post->url);
    }
}

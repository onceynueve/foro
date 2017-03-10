<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;


class CommentController extends Controller
{
    public function store(Request $request,Post $post)
    {
    	/*$comment=new Comment(
    		[
    			'comment'=>$request->get('comment'),
    			'post_id'=>$post->id
    		]
    	);*/

    	//auth()->user()->comments()->save($comment);
    	auth()->user()->comment($post,$request->get('comment'));
    	return redirect($post->url);
    }

    public function accept(Comment $comment)
    {
    	$this->authorize('accept',$comment);
    	$comment->markAsAnswer();
    	return redirect($comment->post->url);
    }
}

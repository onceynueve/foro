<?php
use App\Post;
use Carbon\Carbon;

class PostsListTest extends FeatureTestCase
{
	public function test_a_user_can_see_the_post_list_and_go_to_the_details()
	{
		$post=$this->createPost(['title'=>'Un nuevo post']);
		
		$this->visit('/')
			 ->seeInElement('h1','Posts')
			 ->see($post->title)
			 ->click($post->title)
			 ->seePageIs($post->url);	
	}

	public function test_the_posts_are_paginated()
	{
		$first=factory(Post::class)->create(['title'=>'El primer post','created_at'=>Carbon::now()->subDays(2)]);

		factory(Post::class)->times(15)->create(['created_at'=>Carbon::now()->subDay()]);

		$last=factory(Post::class)->create(['title'=>'El último post','created_at'=>Carbon::now()]);

		$this->visit('/')
			 ->see($last->title)
			 ->dontSee($first->title)
			 ->click('2')
			 ->see($first->title)
			 ->dontSee($last->title);
	}
}

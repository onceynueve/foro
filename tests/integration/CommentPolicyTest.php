<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Comment;
use App\User;
use App\Policies\CommentPolicy;

class CommentPolicyTest extends TestCase
{
	use DatabaseTransactions;

    public function test_the_post_author_can_select_a_comment_as_an_answer()
    {
        $comment=factory(Comment::class)->create();
        $policy=new CommentPolicy();

        $this->assertTrue($policy->accept($comment->post->user,$comment));
    }

    public function test_non_authors_cannot_select_a_comment_as_an_answer()
    {
        $comment=factory(Comment::class)->create();
        $policy=new CommentPolicy();

        $this->assertFalse(
        	$policy->accept(Factory(User::class)->create(),$comment));
    }
}

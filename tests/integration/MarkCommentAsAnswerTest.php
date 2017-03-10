<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MarkCommentAsAnswerTest extends TestCase
{
 	use DatabaseTransactions;


    public function test_a_post_can_be_answered()
    {
        $post=$this->createPost();

        $comment=factory(App\Comment::class)->create([
        	'post_id'=>$post->id]);

        $comment->markAsAnswer();

        $this->assertTrue($comment->fresh()->id==$post->fresh()->answer_id);

        $this->assertFalse($post->fresh()->pending);
    }

    public function test_a_post_can_only_have_one_answer()
    {
        $post=$this->createPost();

        $comments=factory(App\Comment::class)->times(2)->create([
        	'post_id'=>$post->id]);

        $comments->first()->markAsAnswer();
        $comments->last()->markAsAnswer();

        $this->assertTrue($comments->last()->fresh()->id==$post->fresh()->answer_id);
        $this->assertFalse($comments->first()->fresh()->id==$post->fresh()->answer_id);
    }
}

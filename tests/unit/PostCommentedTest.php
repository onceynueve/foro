<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Notifications\PostCommented;
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{
	use DatabaseTransactions;

    public function test_it_builds_a_mail_message()
    {
        $post=factory(App\Post::class)->create(['title'=>'Título del post']);
        $author=factory(App\User::class)->create(
            ['first_name'=>'Fulano',
            'last_name'=>'de Tal']);
        $comment=factory(App\Comment::class)->create(['post_id'=>$post->id,'user_id'=>$author->id]);
        $notification=new PostCommented($comment);
        $subscriber=factory(App\User::class)->create();
        $message=$notification->toMail($subscriber);
        $this->assertInstanceOf(MailMessage::class,$message);
        $this->assertSame('Nuevo comentario en: Título del post', $message->subject);
        $this->assertSame('Fulano de Tal escribió un comentario en: Título del post', $message->introLines[0]);
        $this->assertSame($comment->post->url, $message->actionUrl);
        
        
    }
}

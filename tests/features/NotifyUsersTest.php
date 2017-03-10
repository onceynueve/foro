<?php
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCommented;

class NotifyUsersTest extends FeatureTestCase
{
    
    public function test_the_subscribers_receive_a_notification_when_post_is_commented()
    {
        Notification::fake();
        $post=$this->createPost();

        $subscriber=factory(User::class)->create();
        $subscriber->subscribeTo($post);
        $writer=factory(User::class)->create();
        $comment=$writer->comment($post,'Un comentario cualquiera');
        Notification::assertSentTo($subscriber,PostCommented::class,
        	function($notification) use ($comment)
        	{
        		return $notification->comment->id==$comment->id;
        	}
        	);
        //el autor del comentario no debe recibir notificación
        $writer->subscribeTo($post);
        Notification::assertNotSentTo($writer,PostCommented::class);
    }
}

<?php


class ShowPostTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_see_the_post_details()
    {
        $user=$this->defaultUser(
        	['name'=>'Fulano de Tal']
        	);

        $post=factory(\App\Post::class)->make(
        	['title'=>'Este es el título del post',
        	'content'=>'Este es el contenido del post']
        	);

        $user->posts()->save($post);

        $this->visit(route('posts.show',$post))
             ->seeInElement('h1',$post->title)
             ->see($post->content)
             ->see($user->name);

    }
}

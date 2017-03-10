<?php

class ShowPostTest extends FeatureTestCase
{
    
    public function test_a_user_can_see_the_post_details()
    {
        $user=$this->defaultUser(
        	['first_name'=>'Fulano',
            'last_name'=>'de Tal']
        	);

        $post=$this->createPost(
        	['title'=>'Este es el título del post',
        	'content'=>'Este es el contenido del post',
        	'user_id'=>$user->id]
        	);

        $this->visit($post->url)
             ->seeInElement('h1',$post->title)
             ->see($post->content)
             ->see("Fulano de Tal");

    }

    public function test_post_url_with_wrong_slugs_still_work()
    {
        $post=$this->createPost(
        	['title'=>'Old title',]);

        $url=$post->url;

        $post->update(['title'=>'New title']);

        $this->get($url)
             ->assertResponseStatus(404);

        

    }


}

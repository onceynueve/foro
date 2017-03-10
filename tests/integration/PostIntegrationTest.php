<?php

class PostIntegrationTest extends FeatureTestCase
{
    public function test_a_slug_is_generated_and_saved_to_the_database()
    {
        $post=$this->createPost(['title'=>'Como instalar Laravel']);
        /*$this->seeInDatabase('posts',[
        	'slug'=>'como-instalar-laravel']);
        */

        $this->assertSame('como-instalar-laravel',$post->fresh()->slug);
    }
}

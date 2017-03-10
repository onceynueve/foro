<?php

/*use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;*/


class ExampleTest extends FeatureTestCase
{
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $user=factory(\App\User::class)->create(['first_name'=>'Fulano','last_name'=>'de Tal','email'=>'ful@no.tal']);
        $this->actingAs($user,'api')
             ->visit('api/user')
             ->see('ful@no.tal')
             ->see('Fulano de Tal');
    }
}

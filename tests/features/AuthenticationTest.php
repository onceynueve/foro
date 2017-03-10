<?php

use App\Token;
class AuthenticationTest extends FeatureTestCase
{

    public function test_a_guest_user_can_request_a_token()
    {
    	Mail::fake();
    	$user=$this->defaultUser(['email'=>'admin@b.net']);

    	$this->visitRoute('login')
    	     ->type('admin@b.net','email')
    	     ->press('Solicitar token');

    	$token=Token::where('user_id',$user->id)->first();

    	$this->assertNotNull($token);

    	Mail::assertSentTo($user,App\Mail\TokenMail::class,
    		function($mail) use ($token)
    		{
    			return $mail->token->id===$token->id;
    		}
    		);

    	$this->dontSeeIsAuthenticated();

    	$this->see('Enviamos a tu email un enlace para que inicies sesión');

        
    }

    public function test_a_guest_user_can_request_a_token_without_an_email()
    {
    	Mail::fake();

    	$this->visitRoute('login')
    	     ->press('Solicitar token');
    	
    	$token=Token::first();

    	$this->assertNull($token,'A token was created');

    	Mail::assertNotSent(App\Mail\TokenMail::class);

    	$this->dontSeeIsAuthenticated();

    	$this->seeErrors(['email'=>'El campo correo electrónico es obligatorio']);

        
    }

    public function test_a_guest_user_can_request_a_token_an_invalid_email()
    {
 
    	$this->visitRoute('login')
    	     ->type('algo','email')
    	     ->press('Solicitar token');
    	
    	$this->seeErrors(['email'=>'Correo electrónico no es un correo válido']);

        
    }

     public function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
    {
    	$this->defaultUser(['email'=>'admin@b.net']);
    	
    	$this->visitRoute('login')
    	     ->type('cono@boyu.net','email')
    	     ->press('Solicitar token');
    	
    	$this->seeErrors(['email'=>'El campo correo electrónico no existe']);

        
    }
}

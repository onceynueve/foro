<?php

use Illuminate\Support\Facades\Mail;

use App\User;
use App\Token;
use App\Mail\TokenMail;

class RegistrationTest extends FeatureTestCase
{
    public function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->visitRoute('register')
             ->type('admin@app.net','email')
             ->type('fulano','username')
             ->type('Fulano','first_name')
             ->type('de Tal','last_name')
             ->press('Regístrate');

        $this->seeInDatabase('users',
        	[
        	'email'=>'admin@app.net',
        	'username'=>'fulano',
        	'first_name'=>'Fulano',
        	'last_name'=>'de Tal',
        	]);

        $user=User::first();

        $this->seeInDatabase('tokens',
        	['user_id'=>$user->id]);

        $token=Token::where('user_id',$user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user,TokenMail::class,
        	function($mail) use ($token)
        	{
        		return $mail->token->id==$token->id;
        	});
        //TODO
        /*$this->seeRouteIs('register_confirmation')
             ->see('Gracias por registrarte')
             ->see('Enviamos a tu email un enlace para que inicies sesión');*/
    }
}

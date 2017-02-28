<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    //se crea una transacción para las consultas
    //ejecutadas y al final se realiza un rollback
    //para limpiar las tablas modificadas en la
    //prueba
    use DatabaseTransactions;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $user=factory(\App\User::class)->create(['name'=>'Fulano de Tal','email'=>'ful@no.tal']);
        $this->actingAs($user,'api')
             ->visit('api/user')
             ->see('ful@no.tal')
             ->see('Fulano de Tal');
    }
}

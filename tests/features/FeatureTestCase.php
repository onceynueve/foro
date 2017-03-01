<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeatureTestCase extends TestCase
{
    //se crea una transacción para las consultas
    //ejecutadas y al final se realiza un rollback
    //para limpiar las tablas modificadas en la
    //prueba
    use DatabaseTransactions;

    public function seeErrors(array $fields)
    {
    	foreach($fields as $name => $errors){
    		foreach ((array)$errors as $message) {
    			$this->seeInElement(
    				"#field_{$name}.has-error .help-block",$message
    				);
    		}

    	}
    }
}

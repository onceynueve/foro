<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeatureTestCase extends TestCase
{
    //se crea una transacción para las consultas
    //ejecutadas y al final se realiza un rollback
    //para limpiar las tablas modificadas en la
    //prueba
    use DatabaseTransactions;
}

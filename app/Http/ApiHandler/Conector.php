<?php
namespace App\Http\ApiHandler;

interface Conector
{
    
    public function conection();
    
    
    public function getData();
    
    
    public function getSchema( $data );
    
    
    public function start();
    
    
    public function getResult();
}


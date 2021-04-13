<?php
namespace app\Http\ApiHandler;
use GuzzleHttp\Client;

class ManagerApi 
{
    
    private $httpClient;
    
    
    
    
    public static function init()
    {
        return new static;
    }
    
    /***
     * 
     * @param $config array
     * Ejemplo: ['base_uri'=>'http://api.lobeliaservices.com.dev/api/v1/']
     * */
    public function client( array $config = [] )
    {
        $this->httpClient = new Client($config);
        
        return $this;
    }
    
    /**
     * @param $uri string Ej: direcccion/servicio?
     * @param $query array Ej: ['query' => ['foo' => 'bar']]
     * 
     * */
    public function get( $uri, array $query = [])
    {
        return $this->httpClient->get($uri);
    }
    

}


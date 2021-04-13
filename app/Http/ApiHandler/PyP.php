<?php
namespace App\Http\ApiHandler;

use GuzzleHttp;
use GuzzleHttp\Psr7\Response;

class PyP implements Conector
{
    
    private $conn;
    
    private $result;
    
    private $config = [
        'base_uri'=>'https://www.pypdatos.com.ar'
        
    ];
    
    
    /**
     * @method conection()
     * @return PyP
     * */
    public function conection()
    {
        $this->conn = ManagerApi::init()->client($this->config);
        return $this;
    }

    
    public function getData()
    {        
        return $this->conn->get("/PypAPI/rest/serviciospyp/persona/wscentra/rlikqj79/".$this->params());
    }
    
    
    public function getSchema( $data )
    {
        return new PyPScheme($data);
    }
    
    
    protected function params()
    {
        return implode('/', [
            request('documento'),
            'M',
            'json'
        ]);
    }
    
    
    public function start()
    {
        $response = $this->conection()->setDataResponse($this->getData());
        
        if(!$this->verifyResult($response->result)){
            return $response;
        }
        
    }
    
    
    
    private function setDataResponse(Response $response)
    {
        if($response->getStatusCode() == 200){
            
            $this->result = json_decode((string) $response->getBody(), true);
            return $this;
        }
    }
    
    
    
    public function getResult()
    {
        return $this->result['RESULTADO']['Deudores_de_BCRA_']['row'];
    }
    
    
    
    
    private function verifyResult(array $data)
    {
        return isset($data['RESULTADO']['ERROR']) ?? false;
    }


}


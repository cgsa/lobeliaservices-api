<?php
namespace App\Http\ApiHandler;

use GuzzleHttp;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;

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
        $user = $this->findGender(request('documento'));        
        
        return implode('/', [
            request('documento'),
            $user[0]->sexo,
            'json'
        ]);
    }
    
    
    public function start()
    {
        return $this->conection()->setDataResponse($this->getData());
        
    }
    
    
    
    private function setDataResponse(Response $response)
    {
        if($response->getStatusCode() == 200){            
            $this->result = json_decode((string) $response->getBody(), true);            
        }
        
        return $this;
    }
    
    
    
    public function getResult()
    {
        if(isset($this->result['RESULTADO']['Deudores_de_BCRA_']['row'])){
            return $this->result['RESULTADO']['Deudores_de_BCRA_']['row'];
        }
        
        return null;
    }
    
    
    
    
    private function verifyResult(array $data)
    {
        return isset($data['RESULTADO']['ERROR'])? true : false;
    }
    
    
    private function findGender($documento)
    {
        return DB::connection('mysqlcomopago')->select('SELECT sexo FROM usr_usuarios_sistema WHERE rfc=:documento LIMIT 1;', [
            'documento'=>$documento
        ]);
        
    }


}


<?php
namespace App\Http\ApiHandler;

use Illuminate\Support\Facades\DB;

class CG implements Conector
{
    
    
    private $conn;
    
    private $result;
    
    public function getResult()
    {
        return $this->result;
    }

    public function start()
    {
        $data = $this->conection()->getData();
        //dd($data);
        return $this->setResult($data);
    }

    public function conection()
    {        
        $this->conn = DB::connection('mysqlcontacto');
        return $this;
        
    }

    public function getData()
    {
        
        return $this->conn->select('call comopago_sp01_deudas(:tipo, :documento);', [
            'documento'=>request('documento'),
            'tipo'=>request('tipoDocumento')
        ]);
    }
    
    private function setResult($data)
    {
        if(is_countable($data) && count($data) > 0){
            $this->result = $data;
            return $this;
        }
    }

    public function getSchema($data)
    {
        return new CGScheme($data);
    }

}


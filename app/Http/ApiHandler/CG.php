<?php
namespace App\Http\ApiHandler;

use Illuminate\Support\Facades\DB;

class CG implements Conector
{
    
    
    private $conn;
    
    private $result;
    
    private $document;
    
    
    
    public function setDocument( $documento )
    {
        $this->document = $documento;
        return $this;
    }
    
        
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
        $user = $this->findTipoDocumento($this->document); 
        return $this->conn->select('call comopago_sp01_deudas(:tipo, :documento);', [
            'documento'=> $this->document,
            'tipo'=>$user[0]->tipodocumento
        ]);
    }
    
    private function setResult($data)
    {
        if(is_countable($data) && count($data) > 0){
            $this->result = $data;
        }
        
        return $this;
    }

    public function getSchema($data)
    {
        return new CGScheme($data);
    }
    
    
    private function findTipoDocumento($documento)
    {
        return DB::connection('mysqlcomopago')->select('SELECT tipodocumento FROM usr_usuarios_sistema WHERE rfc=:documento LIMIT 1;', [
            'documento'=>$documento
        ]);
        
    }

}


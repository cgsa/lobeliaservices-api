<?php
namespace App\Http\ApiHandler;

use Illuminate\Support\Carbon;

class PyPScheme implements DeudaScheme
{
    
    private $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function deudaTotal()
    {
        return $this->data['dueda_informada'];
    }
    
    public function codProducto()
    {
        return request('documento');
    }
    
    public function fechaAtraso()
    {
        return $this->formatDate($this->data['fecha']);
    }
    
    public function complementos()
    {
        return json_encode($this->data);
    }
    
    public function fechaRegistro()
    {
        return $this->formatDate(Carbon::now());
    }
    
    public function fechaLote()
    {
        return null;
    }
    
    public function idClasificacion()
    {
        return $this->data['situacion_actual'];
    }
    
    public function documento()
    {        
        return request('documento');
    }
    
    public function tipoSincApi()
    {
        return 1;
    }
    
    public function producto()
    {
        return null;
    }
    
    public function codEntidad()
    {
        return $this->data['banco'];
    }
    
    public function idEstadoDeuda()
    {
        return 1;        
    }  
    
    
    public function iddeuda()
    {
        return null;
    }
    
    
    public function esRefinanciado()
    {
        return null;
    }
    
    protected function formatDate($fecha)
    {
        $aFecha = explode("/", $fecha);
        $fecha = (count($aFecha) == 2) ? $fecha . '/01' : $fecha;
        //$date = date_create($fecha);
        $created = new Carbon($fecha);
        return $created->format("Y/m/d");//date_format($date, "Y/m/d");
    }
}


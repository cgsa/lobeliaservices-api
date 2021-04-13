<?php
namespace App\Http\ApiHandler;

use Illuminate\Support\Carbon;

class CGScheme implements DeudaScheme
{
    
    private $data;
    
    
    public function __construct( $data )
    {
        $this->data = $data;
    }
    
    
    public function deudaTotal()
    {
        return $this->data->deuda_a_gestionar;
    }
    

    public function codProducto()
    {
        return $this->data->nro_producto;
    }
    

    public function fechaAtraso()
    {        
        return $this->formatDate($this->data->fechamora);
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
        return $this->formatDate($this->data->fechalote);
    }
    

    public function idClasificacion()
    {
        return 1;
    }
    

    public function documento()
    {
        return request('documento');
    }
    

    public function tipoSincApi()
    {
        return 3;
    }
    

    public function producto()
    {
        return $this->data->producto;
    }
    

    public function codEntidad()
    {
        return $this->data->cliente;
    }
    

    public function idEstadoDeuda()
    {
        return 1;
    }
    
    
    public function iddeuda()
    {
        return $this->data->iddeuda;
    }
    
    
    public function esRefinanciado()
    {
        return $this->data->tienerefi;
    }
    
    protected function formatDate($fecha)
    {
        $aFecha = explode("-", $fecha);
        $fecha = (count($aFecha) == 2) ? $fecha . '/01' : $fecha;
        //$date = date_create($fecha);
        $created = new Carbon($fecha);
        return $created->format("Y/m/d");//date_format($date, "Y/m/d");
    }

}


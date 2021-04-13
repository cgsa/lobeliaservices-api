<?php
namespace App\Http\ApiHandler;

use App\Models\DeudasApi;
use Illuminate\Support\Facades\DB;

class CGDeudas
{
    
    
    
    public function getDeudaDetalle($iddeuda)
    {
        $data = $this->findDeuda($iddeuda);
        return [
            'deuda'=>$data,
            'detalle'=>$this->getDetalle($data)
        ];
    }
    
    
    public function findDeuda($iddeuda)
    {
        $deuda = DeudasApi::where([
            ['idestadodeuda', '=', '1'],
            ['iddeuda', '=', $iddeuda],
        ])->get();
        
        //         $handler = new Handler($documento);
        //         $handler->build();
        
        return $deuda->first();
    }
    
    
    public function getDetalle($data)
    {
        if($data->es_refinanciado){
            return ['plancreado' => $this->getPlanesCreados($data)];
        }
        
        return ['promociones' => $this->getPlanes($data)];
    }
    
    
    
    public function getPlanesCreados($data)
    {
        return DB::connection('mysqlcontacto')->select('call comopago_sp02_getplancreado(:iddeuda);', [
            'iddeuda'=>$data->iddeuda
        ]);
    }
    
    
    public function getPlanes($data)
    {
        return DB::connection('mysqlcontacto')->select('call comopago_sp03_getposiblesplanes(:iddeuda);', [
            'iddeuda'=>$data->iddeuda
        ]);;
    }
    
    
    
}


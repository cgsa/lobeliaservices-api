<?php
namespace App\Http\ApiHandler;

use App\Models\DeudasApi;
use Illuminate\Support\Facades\DB;

class CGDeudas
{
    
    
    
    public function getDeudaDetalle($iddeuda)
    {
        $data = $this->findDeudaById($iddeuda);
        //dd($data);
        return [
            'success' => 'success',
            'deuda'=>$data,
            'detalle'=>$this->getDetalle($data)
        ];
    }
    
    
    public function findDeudaById($iddeuda)
    {
        $deuda = DeudasApi::where([
            ['idestadodeuda', '=', '1'],
            ['iddeuda', '=', $iddeuda],
        ])->get();
        
        //         $handler = new Handler($documento);
        //         $handler->build();
        
        return $deuda->first();
    }
    
    
    public function findDeudaByDocument($document, $sync = 3)
    {
        $deuda = DeudasApi::where([
            ['idestadodeuda', '=', '1'],
            ['doc_deudor', '=', $document],
            ['tipo_sinc_api', '=', $sync],
            ['deuda_total', '>', 0]
        ])->get();        
        
        
        return $deuda;
    }
    
    
    public function getDetalle($data)
    {
        //dd($data);
        if(isset($data->es_refinanciado) && $data->es_refinanciado == 1){
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
        if(isset($data->iddeuda))
        {
            return DB::connection('mysqlcontacto')->select('call comopago_sp03_getposiblesplanes(:iddeuda);', [
                'iddeuda'=>$data->iddeuda
            ]);
        }
        
    }
    
    
    public function createRefi($request)
    {
        $result = CGRefinanciacion::init($request)->store();
        $result->syncData();
        /*if(isset($result['error']))
        {
            return $result;
        }*/
        
        return $this->getDeudaDetalle($request->deuda);
    }
    
    
    
}


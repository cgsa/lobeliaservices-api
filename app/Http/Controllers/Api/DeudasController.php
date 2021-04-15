<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeudasApi;
use App\Http\ApiHandler\CGDeudas;
use App\Models\Entidad;

class DeudasController extends Controller
{
    
    
    public function __construct()
    {
        $this->middleware('sincronizar.deuda',['only'=>['deudas']]);
    }
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deudas($documento,$tipoDocumento)
    {
        
        
        $deudas = DeudasApi::where([
            ['idestadodeuda', '=', '1'],
            ['doc_deudor', '=',$documento],
        ])->get(); 
        
        
//         $deudaFinal = $deudas->map(function($deuda){
//             $deuda['logo'] = (new Entidad())->getLogo($deuda);
//             return $deuda;
//         });
            //dd($deudaFinal);

//         $handler = new Handler($documento);
//         $handler->build();
        
        return response(['deudas'=>$deudas]);
    }
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deudaDetalle($iddeuda)
    {
        $detalle = new CGDeudas();        
        return response($detalle->getDeudaDetalle($iddeuda));
        
    }
}

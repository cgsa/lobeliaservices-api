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
        $this->middleware('sincronizar.deuda',['only'=>['deudas','deudasBCRA']]);
    }
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deudas($documento,$tipoDocumento)
    {
        
        $deudas = new CGDeudas();        
        
//         $deudaFinal = $deudas->map(function($deuda){
//             $deuda['logo'] = (new Entidad())->getLogo($deuda);
//             return $deuda;
//         });
            //dd($deudaFinal);

//         $handler = new Handler($documento);
//         $handler->build();
        
        return response(['deudas'=>$deudas->findDeudaByDocument($documento)]);
    }
    
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deudasBCRA($documento,$tipoDocumento)
    {
        
        $deudas = new CGDeudas();
        
        return response(['deudas'=>$deudas->findDeudaByDocument($documento, 1)]);
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
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function createRefinanciacion(Request $request )
    {
        $detalle = new CGDeudas();
        $cls = new \stdClass();
        $cls->iddeuda = $request->get('deuda');
        
        $planExistente = $detalle->getPlanesCreados($cls);
        
        if( is_countable($planExistente) && count($planExistente) > 0 ){
            return response($detalle->getDeudaDetalle($cls->iddeuda));
        }
        
        return response($detalle->createRefi($request));
        
    }
}

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
        
        try {
            
            $deudas = new CGDeudas();
            
            //         $deudaFinal = $deudas->map(function($deuda){
            //             $deuda['logo'] = (new Entidad())->getLogo($deuda);
            //             return $deuda;
            //         });
            //dd($deudaFinal);
            
            //         $handler = new Handler($documento);
            //         $handler->build();
            
            return response([
                'data'=>[
                    'success' => 'success',
                    'deudas'=>$deudas->findDeudaByDocument($documento)
                ]                
            ]);
            
        } catch (\Exception $e) {
            return response([
                'error' => 'error',
                'message' => $e->getMessage(),
                ''
            ], 500);
        }        
        
    }
    
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deudasBCRA($documento,$tipoDocumento)
    {
        
        try {
            
            $deudas = new CGDeudas();
            
            return response([
                'data'=>[
                    'success' => 'success',
                    'deudas'=>$deudas->findDeudaByDocument($documento, 1)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response([
                'error' => 'error',
                'message' => $e->getMessage(),
                ''
            ], 500);
        }  
    }
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deudaDetalle($iddeuda)
    {
        
        try {
            
            $detalle = new CGDeudas();
            
            return response([
                'data'=>$detalle->getDeudaDetalle($iddeuda)
            ]);
            
        } catch (\Exception $e) {
            return response([
                'error' => 'error',
                'message' => $e->getMessage(),
                ''
            ], 500);
        }
        
    }
    
    /**
     * Return an json with all debts by user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function createRefinanciacion(Request $request )
    {
        
        try {
            
            $detalle = new CGDeudas();
            $cls = new \stdClass();
            $cls->iddeuda = $request->get('deuda');
            
            $planExistente = $detalle->getPlanesCreados($cls);
            
            if( is_countable($planExistente) && count($planExistente) > 0 ){
                return response([
                    'data'=>$detalle->getDeudaDetalle($cls->iddeuda)
                ]);
            }

            $result = $detalle->createRefi($request);
            
            return response([
                'data'=>[
                    'success' => 'success',
                    'deudas'=> $result
                ]
            ]);
            
        } catch (\Exception $e) {
            return response([
                'error' => 'error',
                'message' => $e->getMessage(),
                ''
            ], 500);
        }
        
    }
}

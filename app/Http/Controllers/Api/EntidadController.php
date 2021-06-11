<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entidad;
use Illuminate\Http\Request;
use App\Models\ConsultaDeuda;

class EntidadController extends Controller
{
    
    
    public function entidades()
    {
        try {
            
            $entidades = Entidad::orderBy('nombre_entidad', 'ASC')->get();
            
            return response([
                'data'=>[
                    'success' => 'success',
                    'entidades'=>$entidades
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
    
    
    public function consultarDeudas(Request $request)
    {
        try {
            
            $request->validate([
                'email'=>'required|email|max:100',
                'email_nuevo'=>'required|email|max:100',
                'notificacion'=>'nullable|bool',
                'telefono'=>'nullable|max:15',
                'id_entidad'=>'required|integer',
                'id_user'=>'required|integer',
            ]);
            
            ConsultaDeuda::create( $request->all() );
            
            return response([
                'data'=>[
                    'success' => 'success',
                    'message' => 'Su información se ha recibido correctamente y está siendo procesada.',
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

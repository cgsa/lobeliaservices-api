<?php
namespace App\Http\ApiHandler;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CGRefinanciacion
{
    
    private $idpromo;
    
    private $iddeuda;
    
    private $fechaVencimiento;
    
    private $documento;
    
    
    public function __construct( Request $request )
    {
        //dd($request->get('deuda'));
        $this->iddeuda = $request->get('deuda');
        $this->idpromo = $request->get('promo');
        $this->fechaVencimiento = $request->get('fecha');
        $this->documento = $request->get('documento');
    }
    
    
    
    private function syncData()
    {
        $handler = new Handler($this->documento,true);
        $handler->build();
    }
    
    
    
    public static function init( Request $request )
    {
        return new static($request);
    }
    
    
    public function store()
    {
        DB::connection('mysqlcontacto')->beginTransaction();
        try {
            
            //$this->eliminaRefinanciacion();
            $this->createDeuda()
            ->createRefinanciacion()
            ->createDetalleRefinanciacion()
            ->createCodeBar();          
            
            DB::connection('mysqlcontacto')->commit();
            $this->syncData();
            
        } catch (\Exception $e) {
            
            DB::connection('mysqlcontacto')->rollback();
            
            return [
                'error' => true,
                'message'=> $e->getMessage()
            ];
        }
        
        return [
            'success' => true,
            'message'=> "La transaccion se realizo de manera satisfactoria"
        ];
        
        
    }
    
    
    private function createDeuda()
    {
        //dd($this->iddeuda);
        DB::connection('mysqlcontacto')->select('call comopago_sp04_creadeudaact( :iddeuda, :idpromo);', [
            'iddeuda'=>$this->iddeuda,
            'idpromo'=>$this->idpromo
        ]);
        
        return $this;
    }
    
    
    private function createRefinanciacion()
    {
        DB::connection('mysqlcontacto')->select('call comopago_sp05_creausrrefi(:iddeuda, :idpromo, :fecha);', [
            'iddeuda'=>$this->iddeuda,
            'idpromo'=>$this->idpromo,
            'fecha'=>$this->fechaVencimiento
        ]);
        
        return $this;
    }
    
    
    private function createDetalleRefinanciacion()
    {
        DB::connection('mysqlcontacto')->select('call comopago_sp06_crearefidetalle(:iddeuda, :idpromo);', [
            'iddeuda'=>$this->iddeuda,
            'idpromo'=>$this->idpromo
        ]);
        
        return $this;
    }
    
    
    private function createCodeBar()
    {
        DB::connection('mysqlcontacto')->select('call comopago_sp07_creacodbars(:iddeuda);', [
            'iddeuda'=>$this->iddeuda
        ]);
        
        return $this;
    }
    
    
    private function eliminaRefinanciacion()
    {
        DB::connection('mysqlcontacto')->select('call comopago_sp08_eliminarefi(:iddeuda);', [
            'iddeuda'=>$this->iddeuda
        ]);
        
        return $this;
    }
}


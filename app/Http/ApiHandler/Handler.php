<?php
namespace app\Http\ApiHandler;


use Illuminate\Support\Carbon;
use App\Models\Actualizacion;
use Illuminate\Support\Facades\DB;

class Handler
{
    protected $structs = [
        '\App\Http\ApiHandler\PyP',
        '\App\Http\ApiHandler\CG'
    ];
    
    private $document;
    
    
    public function __construct( $document , $auto = false)
    {
        $this->document = $document;
        
        if($auto)
        {
            $this->changeStatus();
        }
    }
    
    
    
    
    public function build()
    {
        DB::connection('mysqlcomopago')->beginTransaction();
        
        try {
            
            foreach ($this->structs as $struct){
                
                $this->process( new $struct );
            }
            
            $this->registerSync();
            
            DB::connection('mysqlcomopago')->commit();
            
        } catch (\Exception $e) {
            
            dd($e->getMessage());
            DB::connection('mysqlcomopago')->rollback();
        }
        
        //DB::connection('mysqlcomopago')->commit();
    }
    
    
    public static function apiSinc()
    {
        return new static;
    }
    
    
    private function process(Conector $conn)
    {
        $data = $conn->setDocument($this->document)->start();
        
        if(is_countable($data->getResult())  && count($data->getResult()) > 0 ){
            
            foreach ($data->getResult() as $value){
                $this->insertData($conn->getSchema($value));
            }
        }
        
    }
    
    
    
    private function insertData( DeudaScheme $scheme )
    {
        
        DB::connection('mysqlcomopago')->table('usr_deudas_api')->insert(
            [
                'codproducto' => $scheme->codProducto(), 
                'idclasificacion' => $scheme->idClasificacion(),
                'codentidad' => $scheme->codEntidad() ,
                'doc_deudor' => $scheme->documento() ,
                'deuda_total' => $scheme->deudaTotal() ,
                'json_complemento' => $scheme->complementos() ,
                'fecha_atraso' => $scheme->fechaAtraso() ,
                'fecha_lote' => $scheme->fechaLote() ,
                'fecha_registro' => $scheme->fechaRegistro() ,
                'idestadodeuda' => $scheme->idEstadoDeuda() ,
                'tipo_sinc_api' => $scheme->tipoSincApi() ,
                'producto' => $scheme->producto(),
                'iddeuda' => $scheme->iddeuda(),
                'es_refinanciado' => $scheme->esRefinanciado()
            ]
        );
    }
    
    
    
    public function registerSync()
    {
        DB::connection('mysql')->table('actualizacions')->insert([
            'documento_deudor' => $this->document,
            'client_id' => $this->document,
            'updated_at'=> Carbon::now()
        ]);
        /*return Actualizacion::create([
            'documento_deudor' => $this->document,
            'client_id' => $this->document,
            'updated_at'=> Carbon::now()
        ]);*/
    }
    
    
    
    private function changeStatus()
    {
        //$deudas = DeudasApi::where('doc_deudor',$this->document)->get();
        DB::connection('mysqlcomopago')->update('UPDATE usr_deudas_api SET idestadodeuda = 0 WHERE doc_deudor =:documento', [
            'documento'=>$this->document
        ]);
        /*foreach ($deudas as $deuda) {
            $deuda->idestadodeuda = 0;
            $deuda->save();
        }*/
    }
    
    
    
    
    
    public function syncData()
    {
        $db = Actualizacion::where('documento_deudor',$this->document)->orderBy('id', 'desc')->get();
        
        if(is_object($db) && $db->first())
        {
            $created = new Carbon($db->first()->updated_at);
            $now = Carbon::now();
            
            if( $created->diff($now)->days <= 3 )
            {
                return false;
            }
            
            $this->changeStatus();
        }
        
        return true;
    }
    
}


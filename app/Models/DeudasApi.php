<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeudasApi extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    
    protected $connection = "mysqlcomopago";
    
    protected $table = "usr_deudas_api";
    
    
    protected $hidden = ['id'];
    
    
    protected $fillable = [
        'codproducto', 
        'idclasificacion', 
        'codentidad', 
        'doc_deudor', 
        'deuda_total', 
        'json_complemento', 
        'fecha_atraso', 
        'fecha_lote', 
        'fecha_registro', 
        'idestadodeuda', 
        'tipo_sinc_api', 
        'producto'
        
    ];
}

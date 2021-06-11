<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaDeuda extends Model
{
    use HasFactory;
    
    protected $connection = "mysqlcomopago";
    
    protected $fillable = ['email','email_nuevo','id_entidad','id_user','notificacion','telefono'];
    
    
}

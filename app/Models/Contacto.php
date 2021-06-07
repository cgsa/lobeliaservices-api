<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    
    protected $connection = "mysqlcomopago";
    
    protected $fillable = ['email','telefono','fecha'];
    
}

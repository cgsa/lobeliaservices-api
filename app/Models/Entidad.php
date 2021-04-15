<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;
    
    protected $connection = "mysqlcomopago";
    
    protected $table = "usr_entidades";
    
    
    public function getLogo(DeudasApi $deuda)
    {
        $entidad = $this->where([
            ['codapi'=> $deuda->codentidad]
        ]);
        
        if(is_countable($entidad) && isset($entidad->logo)){
            
            return $this->makeImage('bcra_default.jpg');
        }
        
        return $this->makeImage('bcra_default.jpg');
    }
    
    
    private function makeImage($image)
    {
        
        $path = 'http://192.168.128.5/new-comopago/upload/img/' . $image;
        $file_headers = @get_headers($path);
        
        if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
            
            
            
            // Extensión de la imagen
            $type = pathinfo($path, PATHINFO_EXTENSION);
            
            // Cargando la imagen
            $data = file_get_contents($path);
            
            // Decodificando la imagen en base64
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            
            return $base64;
        }       
        
    }
}

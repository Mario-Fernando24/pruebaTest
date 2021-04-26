<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'tipo_documento',
        'num_documento',
        'nombre',
        'apellido',
        'ciudad',
        'latitud',
        'longitud'
    ];


}

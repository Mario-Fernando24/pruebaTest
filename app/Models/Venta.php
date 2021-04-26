<?php

namespace App\Models;
use App\Models\Cliente;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    
    protected $table = 'venta';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_cliente',
        'valor_venta',
        
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class,'id_cliente');
    }

}


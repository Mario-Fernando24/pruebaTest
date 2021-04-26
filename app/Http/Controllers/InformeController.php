<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Venta;

class InformeController extends Controller
{
    public function grafica(Request $request)
    {
        $hora=Carbon::now('America/Bogota');


        $ventaMayorValor = DB::table('detalle_ventas as d')
        ->join('articulos as art','art.id','=','d.id_articulo')
        ->join('ventas as v','v.id','=','d.id_venta')
       ->select(DB::raw('sum(d.cantidad) as total'),'d.id_articulo','art.nombre')
       ->where('v.estado','registrado')
       ->groupBy('d.id_articulo')
       ->orderBy('total', 'desc')
       ->take(5)
       ->get();
     }
}

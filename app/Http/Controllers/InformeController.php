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
        $fechaActual=Carbon::now('America/Bogota');


        $ventaTotal = DB::table('venta as v')
       ->select(DB::raw('sum(v.valor_venta) as total'))
       ->where('v.estado',1)
       ->whereDate('v.created_at',$fechaActual)
       ->take(1)
       ->get();

       $numVenta = DB::table('venta as v')
       ->select(DB::raw('count(*) as total'))
       ->where('v.estado',1)
       ->whereDate('v.created_at',$fechaActual)
       ->take(1)
       ->get();

       $MenorVenta=Venta::where('estado',1)
       ->whereDate('created_at',$fechaActual)
       ->min('valor_venta');

       $mayorVenta=Venta::where('estado',1)
       ->whereDate('created_at',$fechaActual)
       ->max('valor_venta');
      

       return ['ventaTotal'=>$ventaTotal,'numVenta'=>$numVenta,'MenorVenta'=>$MenorVenta,'mayorVenta'=>$mayorVenta];      

     }
}


// = DB::table('venta as v')
// ->where('v.estado',1)
// ->whereDate('v.created_at',$fechaActual)
// ->max('valor_venta')
// ->fir();
<?php

namespace App\Http\Controllers;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function allVenta(Request $request) {

        // if(!$request->ajax()){return redirect('/');}

        $buscar = $request->buscar;

         if($buscar==''){
          $all_venta = Venta::with('cliente')->where('estado',1)->orderBy('id', 'desc')->paginate(10);
         }else{
            $all_venta = Venta::with('cliente')->where('created_at', 'like', '%'.$buscar.'%')->where('estado',1)->orderBy('id', 'desc')->paginate(10);
         }
            return [
                'pagination' => [
                    //numero total de registro
                    'total'         => $all_venta->total(),
                    //Obtenga el número de página actual.
                    'current_page'  => $all_venta->currentPage(),
                    //El número de elementos que se mostrarán por página.
                    'per_page'      => $all_venta->perPage(),
                  //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                    'last_page'     => $all_venta->lastPage(),
                    //desde la pagina
                    'from'          => $all_venta->firstItem(),
                    //hasta la pagina
                    'to'            => $all_venta->lastItem(),
                ],
                'all_venta' => $all_venta
            ];

    }

    



    public function register(Request $request) {


        try 
        {
                 $validator = Validator::make($request->all(), [
                     'id_cliente'=>'required',
                     'valor_venta' => 'required',
                 ]);

                 $cliente = Venta::create([
                 'id_cliente' => $request->get('id_cliente'),
                 'valor_venta' => $request->get('valor_venta'),
                 ]);
         
                return response()->json(['status' => true],200);
         } catch (\Exception $exception) {

         return response()->json([$exception->getMessage()], 401);

     }
 }


         public function desactivar(Request $request)
        {
            if(!$request->ajax()){return redirect('/');}
            $producto = Venta::findOrFail($request->get('id'));
            $producto->estado=0;
            $producto->update();
        }


}

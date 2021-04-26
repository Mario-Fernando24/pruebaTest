<?php

namespace App\Http\Controllers;
use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class ClienteController extends Controller
{
    public function allCliente(Request $request) {

        // if(!$request->ajax()){return redirect('/');}
        $buscar = $request->buscar;
        $criterio = $request->criterio;

         if($buscar==''){
          $all_cliente = Cliente::orderBy('id', 'desc')->paginate(10);
         }else{
            $all_cliente = Cliente::where($criterio, 'like', '%'.$buscar.'%')->orderBy('id', 'desc')->paginate(10);
         }
            return [
                'pagination' => [
                    //numero total de registro
                    'total'         => $all_cliente->total(),
                    //Obtenga el número de página actual.
                    'current_page'  => $all_cliente->currentPage(),
                    //El número de elementos que se mostrarán por página.
                    'per_page'      => $all_cliente->perPage(),
                  //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                    'last_page'     => $all_cliente->lastPage(),
                    //desde la pagina
                    'from'          => $all_cliente->firstItem(),
                    //hasta la pagina
                    'to'            => $all_cliente->lastItem(),
                ],
                'all_cliente' => $all_cliente
            ];

    }


    public function register(Request $request) {

           try 
           {
                    $validator = Validator::make($request->all(), [
                        'tipo_documento'=>'required',
                        'num_documento' => 'required|unique:users',
                        'nombre' => 'required',
                        'apellido' => 'required',
                        'ciudad' => 'required',
                        // 'latitud' => 'required',
                        // 'longitud' => 'required'
                    ]);

                    $cliente = Cliente::create([
                    'tipo_documento' => $request->get('tipo_documento'),
                    'num_documento' => $request->get('num_documento'),
                    'nombre' => $request->get('nombre'),
                    'apellido' => $request->get('apellido'),
                    'ciudad' => $request->get('ciudad'),
                    'latitud' => $request->get('latitud'),
                    'longitud' => $request->get('longitud'),
                    ]);
            
                   return response()->json(['status' => true],200);
            } catch (\Exception $exception) {

            return response()->json([$exception->getMessage()], 401);

        }
    }





    public function desactivar(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}
        $producto = Cliente::findOrFail($request->get('id'));
        $producto->estado=0;
        $producto->update();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()){return redirect('/');}
        $producto = Cliente::findOrFail($request->get('id'));
        $producto->estado=1;
        $producto->update();
    }





 
}

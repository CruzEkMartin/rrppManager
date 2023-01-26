<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Muestra el listado principal de usuarios, invocado desde ajax y retorna un json.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //$usuarios = User::all();
            $usuarios = DB::table('users')
                ->select(
                    'id',
                    'name',
                    'email',
                    'phone',
                    DB::raw('(CASE permiso WHEN 0 THEN "ADMINISTRADOR" WHEN 1 THEN "CONSULTA" END) AS permiso'),
                    DB::raw('(CASE status WHEN 0 THEN "INACTIVO" WHEN 1 THEN "ACTIVO" END) AS status'),
                )
                ->orderBy('id', 'DESC')
                ->get();

            return Datatables::of($usuarios)
                ->addColumn('action', function ($row) {
                    $html = '<a href="' . route('Usuarios.Editar', $row->id) . '" class="btn btn-sm btn-primary btn-edit"><i class="fa fa-edit mr-2"></i>Editar</a> ';
                    // $html .= '<button data-rowid="' . $row->id . '" class="btn btn-xs btn-danger btn-delete">Del</button>';
                    return $html;
                })->make(true);//->toJson();
        }

        return view('usuarios.index');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('usuarios.createUsuario');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $fecha = Carbon::now();
        // $fecha = $fecha->subHour(5);
        //
        //
        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'regex:/^([0-9]{10})$/','min:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'radio' => ['required', 'bool'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //inicia la transaccion
        try {
            DB::beginTransaction();

            //guardamos la solicitud
            $usuario = new User();
            $usuario->name = $request->get('name');
            $usuario->email = $request->get('email');
            $usuario->phone = $request->get('phone');
            $usuario->password = Hash::make($request->get('password'));
            $usuario->permiso =  $request->get('radio');
            $usuario->status = $request->has('status') ? "1" : "0";
            $usuario->save();
            //si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();
            return redirect('/usuarios')->with('scssmsg', 'Se ha guardado correctamente el usuario');
        } catch (\Exception $e) {
            //en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar guardar el usuario, intente de nuevo. ' . $e);
        }

        return redirect()->route('Usuarios.Index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $usuario = User::find($id);

        return view('usuarios.editUsuario', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $fecha = Carbon::now();

        //
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^([0-9]{10})$/','min:10'],
            'radio' => ['required', 'bool'],
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //inicia la transaccion
        try {
            DB::beginTransaction();

            //$activo = Input::has('status') ? true : false;

            $usuario = User::where('id', $id)->first();
            $usuario->name = $request->get('name');
            $usuario->phone = $request->get('phone');
            $usuario->permiso =  $request->get('radio');
            $usuario->status = $request->has('status') ? "1" : "0";
            $usuario->save();
            //si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();
            return redirect('/usuarios')->with('scssmsg', 'Se ha actualizado correctamente el usuario');
        } catch (\Exception $e) {
            //en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar actualizar el usuario, intente de nuevo. ' . $e);
        }


        return redirect()->route('Usuarios.Index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

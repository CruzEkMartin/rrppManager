<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Partido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;


class PartidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         //
         if ($request->ajax()) {

            $partidos = DB::table('c_partidos')
                ->select(
                    'id',
                    'name',
                    'siglas',
                    DB::raw('(CASE status WHEN 0 THEN "INACTIVO" WHEN 1 THEN "ACTIVO" END) AS status'),
                )
                ->orderBy('id', 'ASC')
                ->get();

                //dd($sectores);

            return Datatables::of($partidos)
                ->addColumn('action', function ($row) {
                    $html = '<a href="' . route('Partidos.Editar', $row->id) . '" class="btn btn-sm btn-primary btn-edit"><i class="fa fa-edit mr-2"></i>Editar</a> ';
                    // $html .= '<button data-rowid="' . $row->id . '" class="btn btn-xs btn-danger btn-delete">Del</button>';
                    return $html;
                })->make(true);//->toJson();
        }

        return view('partidos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('partidos.createPartido');
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
        //
        $fecha = Carbon::now();
        // $fecha = $fecha->subHour(5);
        //
        //
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'siglas' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //inicia la transaccion
        try {
            DB::beginTransaction();

            //guardamos la solicitud
            $partido = new Partido();
            $partido->name = $request->get('name');
            $partido->siglas = $request->get('siglas');
            $partido->status = $request->has('status') ? "1" : "0";
            $partido->save();
            //si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();
            return redirect('/partidos')->with('scssmsg', 'Se ha guardado correctamente el partido');
        } catch (\Exception $e) {
            //en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar guardar el partido, intente de nuevo. ' . $e);
        }

        return redirect()->route('Partidos.Index');
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
        $partido = Partido::find($id);

        return view('partidos.editPartido', compact('partido'));
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
            'siglas' => ['required', 'string', 'max:255'],
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //inicia la transaccion
        try {
            DB::beginTransaction();

            //$activo = Input::has('status') ? true : false;
            $partido = Partido::where('id', $id)->first();
            $partido->name = $request->get('name');
            $partido->siglas = $request->get('siglas');
            $partido->status = $request->has('status') ? "1" : "0";
            $partido->save();
            //si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();
            return redirect('/partidos')->with('scssmsg', 'Se ha actualizado correctamente el partido');
        } catch (\Exception $e) {
            //en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar actualizar el partido, intente de nuevo. ' . $e);
        }

        return redirect()->route('Partidos.Index');
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

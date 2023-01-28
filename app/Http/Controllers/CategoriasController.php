<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Sector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $categorias = DB::table('c_categorias as cat')
            ->join('c_sectores as sec', 'sec.id', '=', 'cat.idSector')
                ->select(
                    'cat.id',
                    'cat.name',
                    DB::raw('(CASE cat.status WHEN 0 THEN "INACTIVO" WHEN 1 THEN "ACTIVO" END) AS status'),
                    'sec.name as sector'
                )
                ->orderBy('cat.id', 'DESC')
                ->get();

            return Datatables::of($categorias)
                ->addColumn('action', function ($row) {
                    $html = '<a href="' . route('Categorias.Editar', $row->id) . '" class="btn btn-sm btn-primary btn-edit"><i class="fa fa-edit mr-2"></i>Editar</a> ';
                    // $html .= '<button data-rowid="' . $row->id . '" class="btn btn-xs btn-danger btn-delete">Del</button>';
                    return $html;
                })->make(true);//->toJson();
        }

        return view('categorias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //visualizamos los sectores
        $sectores = Sector::all();
        return view('categorias.createCategoria', compact('sectores'));
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
            'ddlSector' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //inicia la transaccion
        try {
            DB::beginTransaction();

            //guardamos la solicitud
            $categoria = new Categoria();
            $categoria->name = $request->get('name');
            $categoria->status = $request->has('status') ? "1" : "0";
            $categoria->idSector = $request->get('ddlSector');
            $categoria->save();
            //si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();
            return redirect('/categorias')->with('scssmsg', 'Se ha guardado correctamente la categoría');
        } catch (\Exception $e) {
            //en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar guardar la categoría, intente de nuevo. ' . $e);
        }

        return redirect()->route('Categorias.Index');
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
        $categoria = Categoria::find($id);

        $sectores = Sector::all();

        return view('categorias.editCategoria', compact('categoria', 'sectores'));
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
            'ddlSector' => ['required', 'integer'],
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        //inicia la transaccion
        try {
            DB::beginTransaction();

            //$activo = Input::has('status') ? true : false;
            $categoria = Categoria::where('id', $id)->first();
            $categoria->name = $request->get('name');
            $categoria->status = $request->has('status') ? "1" : "0";
            $categoria->idSector = $request->get('ddlSector');
            $categoria->save();
            //si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();
            return redirect('/categorias')->with('scssmsg', 'Se ha actualizado correctamente la categoría');
        } catch (\Exception $e) {
            //en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar actualizar la categoría, intente de nuevo. ' . $e);
        }


        return redirect()->route('Categorias.Index');
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

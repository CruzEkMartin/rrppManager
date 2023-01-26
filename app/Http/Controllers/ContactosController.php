<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Categoria;
use App\Models\Partido;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ContactosController extends Controller
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
            //$usuarios = User::all();
            $contactos = DB::table('contactos as cont')
                ->join('users as us', 'us.id', '=', 'cont.idUsuario')
                ->join('c_sectores as sec', 'sec.id', '=', 'cont.idSector')
                ->join('c_categorias as cat', 'cat.id', '=', 'cont.idCategoria')
                ->join('c_estados as est', 'est.cve_ent', '=', 'cont.cve_ent')
                ->join('c_municipios as mun', 'mun.cve_mun', '=', 'cont.cve_mun')
                ->join('c_localidades as loc', 'loc.cve_loc', '=', 'cont.cve_loc')
                ->join('c_partidos as part', 'part.id', '=', 'cont.idPartido')
                ->select(
                    'cont.id',
                    'cont.idUsuario',
                    'us.name as Usuario',
                    'cont.idSector',
                    'sec.name as Sector',
                    'cont.idCategoria',
                    'cat.name as Categoria',
                    'cont.genero',
                    DB::raw('(CASE cont.genero WHEN 1 THEN "MASCULINO" WHEN 2 THEN "FEMENINO" END) AS sexo'),
                    'cont.titulo',
                    'cont.nombre',
                    'cont.apellido_paterno',
                    'cont.apellido_materno',
                    DB::raw('CONCAT(cont.nombre, " ", cont.apellido_paterno, " ", cont.apellido_materno) as nombre_completo'),
                    'cont.fecha_nacimiento',
                    'cont.cargo',
                    'cont.area',
                    'cont.dependencia',
                    'cont.telefono_celular',
                    'cont.telefono_oficina',
                    'cont.asistente',
                    'cont.domicilio_laboral',
                    'cont.codigo_postal',
                    'cont.cve_ent',
                    'est.nom_ent as Estado',
                    'cont.cve_mun',
                    'mun.nom_mun as Municipio',
                    'cont.cve_loc',
                    'loc.nom_loc as Localidad',
                    'cont.email_laboral',
                    'cont.email_personal',
                    'cont.idPartido',
                    'part.siglas as Partido',
                    'cont.foto',
                    'cont.observaciones',
                )
                ->orderBy('cont.id', 'DESC')
                ->get();

            return Datatables::of($contactos)
                ->addColumn('action', function ($row) {
                    $html = '<a href="' . route('Contactos.Editar', $row->id) . '" class="btn btn-sm btn-primary btn-edit"><i class="fa fa-edit mr-2"></i>Editar</a> ';
                    // $html .= '<button data-rowid="' . $row->id . '" class="btn btn-xs btn-danger btn-delete">Del</button>';
                    return $html;
                })->make(true); //->toJson();
        }

        return view('contactos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //obtenemos los catalogos
        $sectores = Sector::all();
        $categorias = Categoria::all();
        $partidos = Partido::all();
        $estados = Estado::all();

        return view('contactos.createContacto', compact('sectores', 'categorias', 'partidos', 'estados'));
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

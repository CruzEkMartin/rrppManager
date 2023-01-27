<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Partido;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
                ->join('c_municipios as mun', function($join){
                    $join->on('cont.cve_mun', '=', 'mun.cve_mun');
                    $join->on('cont.cve_ent', '=', 'mun.cve_ent');
                })
                ->join('c_localidades as loc', function($join2){
                    $join2->on('cont.cve_loc', '=', 'loc.cve_loc');
                    $join2->on('cont.cve_mun', '=', 'loc.cve_mun');
                    $join2->on('cont.cve_ent', '=', 'loc.cve_ent');
                })
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

        //ValidationExpression="^([0-9]+){10}$">
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
        $fecha = Carbon::now();

        
        //validamos los campos
        if (($request->hasFile('ContactoFile')) || ($request->has('ContactoFile'))) {
            
            if ($request->has('ContactoFile')) {
                

                 Validator::make($request->all(), [
                    'ddlSector' => ['required', 'integer'],
                    'ddlCategoria' => ['required', 'integer'],
                    'name' => ['required', 'string'],
                    'ApellidoPaterno' => ['required', 'string'],
                    'ApellidoMaterno' => ['required', 'string'],
                    'ddlSexo' => ['required', 'integer'],
                    'Titulo' => ['required', 'string'],
                    'fecha_nac' => ['required', 'string'],
                    'Dependencia' => ['required', 'string'],
                    'Cargo' => ['required', 'string'],
                    'Area' => ['required', 'string'],
                    'Domicilio' => ['required', 'string'],
                    'CodPostal' => ['required', 'integer','digits:5'],
                    'ddlEstado' => ['required', 'string'],
                    'ddlMunicipio' => ['required', 'string'],
                    'ddlLocalidad' => ['required', 'string'],
                    'telefono_celular' => ['required', 'integer','digits:10'],
                    'telefono_oficina' => ['required', 'integer','digits:10'],
                    'email_personal' => ['required', 'email:rfc,dns'],
                    'email_laboral' => ['required', 'email:rfc,dns'],
                    'ddlPartido' => ['required', 'integer'],
                ])->validate();
            }

            if ($request->hasFile('ContactoFile')) {
               
                 Validator::make($request->all(), [
                    'ddlSector' => ['required', 'integer'],
                    'ddlCategoria' => ['required', 'integer'],
                    'name' => ['required', 'string'],
                    'ApellidoPaterno' => ['required', 'string'],
                    'ApellidoMaterno' => ['required', 'string'],
                    'ddlSexo' => ['required', 'integer'],
                    'Titulo' => ['required', 'string'],
                    'fecha_nac' => ['required', 'string'],
                    'Dependencia' => ['required', 'string'],
                    'Cargo' => ['required', 'string'],
                    'Area' => ['required', 'string'],
                    'Domicilio' => ['required', 'string'],
                    'CodPostal' => ['required', 'integer','digits:5'],
                    'ddlEstado' => ['required', 'string'],
                    'ddlMunicipio' => ['required', 'string'],
                    'ddlLocalidad' => ['required', 'string'],
                    'telefono_celular' => ['required', 'integer','digits:10'],
                    'telefono_oficina' => ['required', 'integer','digits:10'],
                    'email_personal' => ['required', 'email:rfc,dns'],
                    'email_laboral' => ['required', 'email:rfc,dns'],
                    'ddlPartido' => ['required', 'integer'],
                    'ContactoFile' => ['file','mimes:jpg,jpeg,pdf,png', ' required', 'max:3072'],
                ])->validate();
            }

          

            // if ($validator->fails()) {
            //     return redirect()->back()->withErrors($validator);
            // }

           
            //inicia la transaccion
            try {
                DB::beginTransaction();


                //* Creamos un nuevo registro
                $contacto = new Contacto();
                $contacto->idUsuario = (Auth::check()) ? Auth::user()->id : 0;
                $contacto->idSector = $request->get('ddlSector');
                $contacto->idCategoria = $request->get('ddlCategoria');
                $contacto->genero = $request->get('ddlSexo');
                $contacto->titulo = $request->get('Titulo');
                $contacto->nombre = $request->get('name');
                $contacto->apellido_paterno = $request->get('ApellidoPaterno');
                $contacto->apellido_materno = $request->get('ApellidoMaterno');
                $contacto->fecha_nacimiento = $request->get('fecha_nac');
                $contacto->cargo = $request->get('Cargo');
                $contacto->area = $request->get('Area'); 
                $contacto->dependencia = $request->get('Dependencia');
                $contacto->telefono_celular = $request->get('telefono_celular');
                $contacto->telefono_oficina = $request->get('telefono_oficina');
                //$contacto->asistente = $request->get('asistente');
                $contacto->domicilio_laboral = $request->get('Domicilio');
                $contacto->codigo_postal = $request->get('CodPostal');
                $contacto->cve_ent = $request->get('ddlEstado');
                $contacto->cve_mun = $request->get('ddlMunicipio');
                $contacto->cve_loc = $request->get('ddlLocalidad');
                $contacto->email_laboral = $request->get('email_laboral');
                $contacto->email_personal = $request->get('email_personal'); 
                $contacto->idPartido = $request->get('ddlPartido');
                $contacto->Observaciones = $request->get('Observaciones');
                $contacto->save();

                $idContacto = $contacto::latest('id')->first(); //busca el id del ultimo registro entrada guardado

                //guardamos la foto o documento
                $directorio = "contacto";
                //        $pathIdDocumentacion = "documentacion/$documentacion->PersonaId/$idDocumentacion";

               
                if ($request->hasFile('ContactoFile')) {
                    $extension = strtolower($request->file('ContactoFile')->getClientOriginalExtension());
                    $request->file('ContactoFile')->storeAs($directorio, $idContacto["id"] . '.' . $extension);
                    $imageName = $idContacto["id"] . '.' . $extension;
                } elseif ($request->has('ContactoFile')) {
                    $image = $request->get('ContactoFile');
                    $image = str_replace('data:image/jpeg;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = $idContacto["id"] . '.' . 'jpg';
                    Storage::disk('public')->put($directorio . "/" . $imageName, base64_decode($image));
                }

                 //actiualizamos la tabla con la ruta
                 $upincidencia = Contacto::find($idContacto["id"]);
                 $upincidencia->Foto = $directorio . "/" . $imageName;
                 $upincidencia->save();

                //* si no hay error en la transaccion hacemos commit y redireccionamos correctamente
                DB::commit();
                return redirect('/contactos')->with('scssmsg', 'Se ha guardado correctamente el contacto');
            } catch (\Exception $e) {
                //! en caso de error hacemos rollback y mandamos mensaje de error
                DB::rollBack();
                return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar actualizar el contacto, intente de nuevo.');
            }
        }
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

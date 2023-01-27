<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueriesController extends Controller
{
    //

    /*******************************************************
     * 
     * devuelve un listado de municipios para ser usado en dropdowns ajax
     * 
     *******************************************************/
    public function obtenerMunicipios(Request $request)
    {

        if (isset($request->texto)) {
            //$subcategorias = Subcategoria::whereCategoria_id($request->texto)->get();
           // $idEstado = $request->texto;

            $municipios = DB::table('c_municipios')
                ->select(
                    'id',
                    'cve_mun',
                    'nom_mun'
                )
                ->where('cve_ent', '=', $request->texto)
                ->where('status', "1")
                ->get();

            //retornamos los valores de la consulta
            return response()->json(
                [
                    'lista' => $municipios,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }


    /*******************************************************
     * 
     * devuelve un listado de localidades para ser usado en dropdowns ajax
     * 
     *******************************************************/
    public function obtenerLocalidades(Request $request)
    {

        if (isset($request->cve_mun)) {
            //$subcategorias = Subcategoria::whereCategoria_id($request->texto)->get();
           // $idEstado = $request->texto;

            $localidades = DB::table('c_localidades')
                ->select(
                    'id',
                    'cve_loc',
                    'nom_loc'
                )
                ->where('cve_ent', '=', $request->cve_ent)
                ->where('cve_mun', '=', $request->cve_mun)
                ->where('status', "1")
                ->orderBy('pob_total','desc')
                ->get();

            //retornamos los valores de la consulta
            return response()->json(
                [
                    'lista' => $localidades,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /*******************************************************
     * 
     * devuelve un listado de municipios para ser usado en dropdowns ajax
     * 
     *******************************************************/
    public function obtenerContacto(Request $request)
    {

        //if (isset($id)) {
            //$subcategorias = Subcategoria::whereCategoria_id($request->texto)->get();
           // $idEstado = $request->texto;

           $data = DB::table('contactos as cont')
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
                ->where('cont.id', '=', $request->id)
                ->first();

                return response()->json($data, 200);
        //     //retornamos los valores de la consulta
        //     return response()->json(
        //         [
        //             'lista' => $contacto,
        //             'success' => true
        //         ]
        //     );
        // } else {
        //     return response()->json(
        //         [
        //             'success' => false
        //         ]
        //     );
       // }

    }

}

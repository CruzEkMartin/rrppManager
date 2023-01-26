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

}

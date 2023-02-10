<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class QueriesController extends Controller
{
    //

    /*******************************************************
     * 
     * devuelve un listado de municipios para ser usado en dropdowns ajax
     * 
     *******************************************************/
    public function obtenerCategorias(Request $request)
    {

        if (isset($request->texto)) {

            $categorias = DB::table('c_categorias')
                ->select(
                    'id',
                    'name'
                )
                ->where('idSector', '=', $request->texto)
                ->where('status', "1")
                ->get();

            //retornamos los valores de la consulta
            return response()->json(
                [
                    'lista' => $categorias,
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
    public function obtenerMunicipios(Request $request)
    {

        if (isset($request->texto)) {

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

            $localidades = DB::table('c_localidades')
                ->select(
                    'id',
                    'cve_loc',
                    'nom_loc'
                )
                ->where('cve_ent', '=', $request->cve_ent)
                ->where('cve_mun', '=', $request->cve_mun)
                ->where('status', "1")
                ->orderBy('pob_total', 'desc')
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
     * devuelve los datos de un contacto para usarlo con ajax
     * 
     *******************************************************/
    public function obtenerContacto(Request $request)
    {

        $data = DB::table('contactos as cont')
            ->join('users as us', 'us.id', '=', 'cont.idUsuario')
            ->join('c_sectores as sec', 'sec.id', '=', 'cont.idSector')
            ->join('c_categorias as cat', 'cat.id', '=', 'cont.idCategoria')
            ->join('c_estados as est', 'est.cve_ent', '=', 'cont.cve_ent')
            ->join('c_municipios as mun', function ($join) {
                $join->on('cont.cve_mun', '=', 'mun.cve_mun');
                $join->on('cont.cve_ent', '=', 'mun.cve_ent');
            })
            ->join('c_localidades as loc', function ($join2) {
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
                'cont.status AS idStatus',
                DB::raw('(CASE cont.status WHEN 1 THEN "ACTIVO" WHEN 0 THEN "INACTIVO" END) AS status'),
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
    }

    /*******************************************************
     * 
     * devuelve un listado de municipios para ser usado en dropdowns ajax
     * 
     *******************************************************/
    public function borrarFotoContacto(Request $request)
    {

        //obtenemos el url de la foto según el id del contacto
        $contacto = Contacto::find($request->id);

        //inicia la transaccion
        try {
            DB::beginTransaction();

            //borramos la foto
            Storage::disk('public')->delete($contacto->foto);

            //actualizamos los datos del contacto
            $contacto->Foto = "";
            $contacto->save();

            //* si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();

            //return redirect('/contactos')->with('scssmsg', 'Se ha guardado correctamente el contacto');
            return response()->json($contacto->id, 200); //->with('scssmsg', 'Se ha eliminado correctamente la fotografía');

        } catch (\Exception $e) {
            //! en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return response()->json(null, 200); //->with('errormsg', 'Ha ocurrido un error al intentar eliminar la fotografía, intente de nuevo.');
            //return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar actualizar el contacto, intente de nuevo.');
        }
    }


    // elimina un contacto desde un datatable, se envía por ajax
    public function borraContacto(Request $request)
    {
        $id = $request->id;
        $contacto = Contacto::find($id);

        //borramos la foto
        Storage::disk('public')->delete($contacto->foto);

        //if (Storage::disk('public')->delete($contacto->foto)) {
        //eliminamos el contacto
        Contacto::destroy($id);
        //}
    }

    // actualiza el status de un contacto desde un datatable, se envía por ajax
    public function statusContacto(Request $request)
    {
        $id = $request->id;
        $contacto = Contacto::find($id);

        try {
            DB::beginTransaction();

            if ($contacto->status == 0) {
                $contacto->status = 1;
            } else {
                $contacto->status = 0;
            }

            $contacto->save();

            //* si no hay error en la transaccion hacemos commit y redireccionamos correctamente
            DB::commit();

            //return redirect('/contactos')->with('scssmsg', 'Se ha guardado correctamente el contacto');
            return response()->json($contacto->id, 200); //->with('scssmsg', 'Se ha eliminado correctamente la fotografía');

        } catch (\Exception $e) {
            //! en caso de error hacemos rollback y mandamos mensaje de error
            DB::rollBack();
            return response()->json(null, 200); //->with('errormsg', 'Ha ocurrido un error al intentar eliminar la fotografía, intente de nuevo.');
            //return Redirect::back()->with('errormsg', 'Ha ocurrido un error al intentar actualizar el contacto, intente de nuevo.');
        }
    }
}

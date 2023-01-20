<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        // $draw = intval($this->input->get("draw"));
        // $start = intval($this->input->get("start"));
        // $length = intval($this->input->get("length"));

        $usuarios = User::all();

        $data = [];


        foreach ($usuarios as $r) {
            $data[] = array(
                //"fila"=>$r->fila,
                "id" => $r->id,
                "name" => $r->name,
                "email" => $r->email,
                "permiso" => $r->permiso,
                "status" => $r->status
                
            );
        }


        $todos = array(
            "recordsTotal" => count($usuarios),
            "recordsFiltered" => count($usuarios),
            "data" => $data
        );


        echo json_encode($todos);
        return response()->json(['data' => $data]);
        return;


        //return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    public function index()
    {
        $salas = Sala::all();
        return view('salas.index',['salas' => $salas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',
        ]);
        Sala::create($validated);
        return redirect("/salas")->with('message',"Sala creada correctamente");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sala = Sala::find($id);
        if(!$sala){
            return redirect("salas.index")->with("info","La sala no existe");
        }
        return view('salas.edit',[
            "id" => $sala->id,
            "nombre" => $sala->nombre
        ]);
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
        $validated = $request->validate([
            'nombre' => 'required|max:255',
        ]);
        $sala = Sala::find($id);
        $sala->nombre = $validated["nombre"];
        $sala->save();
        return redirect("/salas")->with('message',"Sala actualizada correctamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sala::destroy($id);
        return redirect("salas")->with("info","La se eliminó correctamente");
    }
}

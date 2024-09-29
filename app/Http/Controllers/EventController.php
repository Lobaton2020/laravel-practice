<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sala;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function eventos($id_sala)
    {
        $sala = Sala::find($id_sala);
        return view('eventos.detalle', [
            "sala" => $sala,
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'state' => 'required|in:Busy,Free',
            'id_sala' => 'required|numeric|exists:salas,id',
        ]);


        $event = Event::create($validatedData);

        return response()->json(['success' => true, 'event' => $event], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'state' => 'required|in:Busy,Free',
            'id_sala' => 'required|numeric|exists:salas,id'
        ]);

        $event = Event::findOrFail($id);
        $event->update($validatedData);

        return response()->json(['success' => true, 'event' => $event], 200);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['success' => true], 200);
    }
}

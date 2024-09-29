<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Sala;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class SalasProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'SalasProcedure';

    /**
     * Execute the procedure.
     *
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function getAll(Request $request)
    {
        return Sala::all();
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:255',
        ]);
        Sala::create($validated);
    }
}

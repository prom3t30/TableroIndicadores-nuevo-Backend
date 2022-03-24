<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Lineaprogramatica;
use App\Http\Controllers\Controller;
use App\Http\Resources\Lineaprogramatica as LineaprogramaticaResource;
use App\Http\Resources\LineaprogramaticaCollection;

class LineaProgramaticaController extends Controller
{
    public function index()
    {
        return new LineaprogramaticaCollection(DB::table('Lineaprogramatica')
            ->where('Lineaprogramatica.deleted_at', '=', null)
            ->select('Lineaprogramatica.id as l_id', 'Lineaprogramatica.*', 'users.*')
            ->leftJoin('users', 'Lineaprogramatica.ResponsableLinea', '=', 'users.id')
            ->get());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'ResponsableLinea' => 'required|max:100000|integer',
        ]);
        $Lineaprogramatica = Lineaprogramatica::create($request->all());
        return (new LineaprogramaticaResource($Lineaprogramatica))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new LineaprogramaticaResource(Lineaprogramatica::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'ResponsableLinea' => 'required|max:100',
        ]);
        $Lineaprogramatica = Lineaprogramatica::where('id', '=', $request->id)->first();
        $Lineaprogramatica->update($request->all());
        $Lineaprogramatica = Lineaprogramatica::where('id', '=', $request->id)->first();
        return (new LineaprogramaticaResource($Lineaprogramatica))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Lineaprogramatica = Lineaprogramatica::findOrFail($id);
        $Lineaprogramatica->delete();
        return response()->json("Eliminado", 204);
    }
}

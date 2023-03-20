<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CdgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cdg = DB::Table('cdg_objets')->select('*')
            ->orderByRaw("FIELD(type_stuff, 'APOCALYPSE', '135')")
            ->orderByRaw("FIELD(classe, 'Chevalier', 'Assassin', 'Prêtre', 'Moine', 'Ranger', 'Jester', 'Sorcier', 'Elementaliste')")
            ->orderBy('genre', 'desc')
            ->orderByRaw("FIELD(libelle, 'Casque', 'Torse', 'Gants', 'Bottes')")
            ->get();

        // foreach ($cdgGet->chunk(8) as $chunk) {
        //     $cdg[] = $chunk;
        // }

        return response()->json($cdg);
    }

    public function addOneItem($id)
    {
        $request = DB::Table('cdg_objets')->where('id', '=', $id)->update(['quantite' => DB::raw('quantite + 1')]);
    }

    public function removeOneItem($id)
    {
        $request = DB::Table('cdg_objets')->where('id', '=', $id)->update(['quantite' => DB::raw('quantite - 1')]);
    }
}

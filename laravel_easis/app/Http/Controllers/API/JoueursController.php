<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class JoueursController extends Controller
{
    public function index()
    {
        $joueurs = DB::Table('joueurs')->select('*')
            ->orderBy("nombre_donjons", "desc")
            ->get();

        return response()->json($joueurs);
    }

    public function addOneItem($id)
    {
        $request = DB::Table('joueurs')->where('id', '=', $id)->update(['nombre_donjons' => DB::raw('nombre_donjons + 1')]);
    }

    public function removeOneItem($id)
    {
        $request = DB::Table('joueurs')->where('id', '=', $id)->update(['nombre_donjons' => DB::raw('nombre_donjons - 1')]);
    }
}

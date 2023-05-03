<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DiscordController extends Controller
{
    public function index()
    {
        $joueurs = DB::Table('joueurs')->select('*')
            ->orderByRaw("LOWER(pseudo) ASC")
            ->get();

        $instances = DB::Table('instance_joueur')->select('*')
            ->get();

        foreach ($joueurs as $joueur) {
            $joueur->nombre_instance = 0;
            foreach ($instances as $instance) {
                if ($joueur->id == $instance->id_joueur) {
                    $joueur->nombre_instance += 1;
                }
            }
        }

        return response()->json($joueurs);
    }

}

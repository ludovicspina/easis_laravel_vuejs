<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonjonsController extends Controller
{
    public function objets()
    {
        $donjons_objets = DB::Table('donjons_objets')->select('*')
            ->get();

        return response()->json($donjons_objets);
    }

    public function objetsJoueurs()
    {
        $donjons_objets_joueurs = DB::Table('donjons_objets_joueurs')
            ->select('*')
            ->join('joueurs', 'donjons_objets_joueurs.id_joueur', '=', 'joueurs.id')
            ->join('donjons_objets', 'donjons_objets_joueurs.id_donjon_objet', '=', 'donjons_objets.id')
            ->get();
        return response()->json($donjons_objets_joueurs);
    }

    public function objetsDonjonsJoueursCount()
    {

        // Requete qui compte le nombre d'objets par joueurs en affichant le pseudo depuis la table donjons_objets_joueurs
        $donjons_objets_joueurs = DB::Table('donjons_objets_joueurs')
            ->select('joueurs.pseudo', DB::raw('count(*) as nombre_objets'))
            ->join('joueurs', 'donjons_objets_joueurs.id_joueur', '=', 'joueurs.id')
            ->join('donjons_objets', 'donjons_objets_joueurs.id_donjon_objet', '=', 'donjons_objets.id')
            ->groupBy('joueurs.pseudo')
            ->get();

        return response()->json($donjons_objets_joueurs);
    }


    public function createItem(Request $request)
    {
        // Insérez les données de base de l'objet dans la table 'donjons_objets'
        $donjonObjetId = DB::table('donjons_objets')->insertGetId([
            'libelle' => $request->input('libelle'),
            'contribution' => $request->input('contribution')
        ]);

        // Récupérer la liste des joueurs participant à l'objet
        $participants = $request->input('participants');

        // Insérez chaque joueur participant à l'objet dans la table 'donjons_objets_joueurs'
        foreach ($participants as $joueur) {
            DB::table('donjons_objets_joueurs')->insert([
                'id_donjon_objet' => $donjonObjetId,
                'id_joueur' => $joueur
            ]);
        }

        return response()->json(['message' => 'Objet créé avec succès']);
    }

}

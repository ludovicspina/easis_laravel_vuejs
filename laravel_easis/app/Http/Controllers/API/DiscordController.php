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

        $repartition = DB::Table('instance_repartition')->select('*')
            ->get();

        $objets = DB::Table('objets')->select('*')
            ->get();

        foreach ($repartition as $repart) {
            $repart->categorie = "a";
            foreach ($objets as $obj) {
                if ($obj->id === $repart->id_objet) {
                    $repart->categorie = $obj->categorie;
                }
            }
        }

        foreach ($joueurs as $joueur) {
            $joueur->carte_a = 0;
            $joueur->carte_b = 0;
            $joueur->carte_c = 0;
            $joueur->carte_d = 0;
            $joueur->familier_f = 0;
            $joueur->familier_e = 0;
            $joueur->familier_d = 0;
            $joueur->familier_c = 0;
            $joueur->familier_b = 0;
            $joueur->familier_a = 0;
            $joueur->familier_s = 0;
            foreach ($repartition as $repart) {
                if ($repart->id_joueur === $joueur->id) {
                    if ($repart->categorie === "a") {
                        $joueur->carte_a += 1;
                    } else if ($repart->categorie === "b") {
                        $joueur->carte_b += 1;
                    } else if ($repart->categorie === "c") {
                        $joueur->carte_c += 1;
                    } else if ($repart->categorie === "d") {
                        $joueur->carte_d += 1;
                    } else if ($repart->categorie === "ff") {
                        $joueur->familier_f += 1;
                    } else if ($repart->categorie === "fe") {
                        $joueur->familier_e += 1;
                    } else if ($repart->categorie === "fd") {
                        $joueur->familier_d += 1;
                    } else if ($repart->categorie === "fc") {
                        $joueur->familier_c += 1;
                    } else if ($repart->categorie === "fb") {
                        $joueur->familier_b += 1;
                    } else if ($repart->categorie === "fa") {
                        $joueur->familier_a += 1;
                    } else if ($repart->categorie === "fs") {
                        $joueur->familier_s += 1;
                    }
                }
            }

            $joueur->nombre_instance = 0;
            foreach ($instances as $instance) {
                if ($joueur->id == $instance->id_joueur) {
                    $joueur->nombre_instance += 1;
                }
            }
            if ($joueur->nombre_instance !== 0) {
                $joueur->ratio = (((($joueur->carte_c * 8) + ($joueur->carte_b * 20) + ($joueur->carte_a * 50) + ($joueur->familier_f * 1) + ($joueur->familier_e * 2) + ($joueur->familier_d * 3) + ($joueur->familier_c * 8) + ($joueur->familier_b * 12) + ($joueur->familier_a * 15) + ($joueur->familier_s * 18)) / $joueur->nombre_instance) * 100);
            }
        }

        return response()->json($joueurs);
    }

}

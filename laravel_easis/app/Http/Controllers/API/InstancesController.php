<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\objets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstancesController extends Controller
{
    public function getAll()
    {
        $instances = DB::Table('instances')->select('*')
            ->join('instance_joueur', 'instance_joueur.id_instance', '=', 'instances.id')
            ->join('joueurs', 'joueurs.id', '=', 'instance_joueur.id_joueur')
            ->join('instance_objet', 'instance_objet.id_instance', '=', 'instances.id')
            ->join('objets', 'objets.id', '=', 'instance_objet.id_objet')
            ->get();

        return response()->json($instances);
    }

    // lier un objet depuis la table instance_objet à un joueur sur la table instance_repartition
    public function addRepartition(Request $request)
    {
        $id_objet = $request->input('repartitionObjet');
        $id_joueur = $request->input('repartitionJoueur');

        $repartition = DB::table('instance_repartition')->insert([
            'id_objet' => $id_objet,
            'id_joueur' => $id_joueur,
        ]);

        return response()->json(['message' => 'Objet créé avec succès']);
    }

    public function getRepartition(): \Illuminate\Http\JsonResponse
    {
        $repartition = DB::Table('instance_repartition')->select('*')
            ->get();

        return response()->json($repartition);
    }


    public function getInstances()
    {
        $instances = DB::Table('instances')->select('*')
            ->orderBy("date", "desc")
            ->get();

        return response()->json($instances);
    }

    public function getInstancesObjets()
    {
        $instances = DB::Table('instances')->select('*')
            ->join('instance_objet', 'instance_objet.id_instance', '=', 'instances.id')
            ->join('objets', 'objets.id', '=', 'instance_objet.id_objet')
            ->get();

        return response()->json($instances);
    }

    public function getInstancesParticipants()
    {
        $instances = DB::Table('instances')->select('*')
            ->join('instance_joueur', 'instance_joueur.id_instance', '=', 'instances.id')
            ->join('joueurs', 'joueurs.id', '=', 'instance_joueur.id_joueur')
            ->get();

        return response()->json($instances);
    }

    public function getInstancesNumber()
    {
        $instances = DB::Table('instance_joueur')
            ->select('*')
            ->get();
        return response()->json($instances);
    }

    public function getBase()
    {
        $instances = DB::Table('objets')->select('*')
            ->get();

        return response()->json($instances);
    }

    public function addInstance(Request $request)
    {

        $participants = $request->input('participants');
        $objets = $request->input('objets');


        $instance = DB::table('instances')->insertGetId([
            'date' => $request->input('date'),
            'heure' => $request->input('heure'),
        ]);


        foreach ($participants as $participant) {
            DB::table('instance_joueur')->insert([
                'id_instance' => $instance,
                'id_joueur' => $participant
            ]);
        }


        foreach ($objets as $objet) {
            DB::table('instance_objet')->insert([
                'id_instance' => $instance,
                'id_objet' => $objet,
            ]);
        }

        return response()->json(['message' => 'Objet créé avec succès']);
    }

    public function getDungeonsItems()
    {
        // $dungeon = file_get_contents("https://api.flyff.com/monster/1179");
        //        $dungeonJson = json_decode($dungeon);
        //        $dungeonItemsIds = array_map(function ($drop) {
        //            return $drop->item;
        //        }, $dungeonJson->drops);
        //
        //        $itemsDungeon = file_get_contents('https://api.flyff.com/item/' . implode(',', $dungeonItemsIds));
        //
        //        $dungeonItemsJson = json_decode($itemsDungeon);
        //
        //        $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        //            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        //            'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        //            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        //            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', '-' => '');
        //
        //        $data = DB::table('objets')
        //            ->select('*')
        //            ->get();
        //
        //        $dataIds = [];
        //        foreach ($data as $d) {
        //            array_push($dataIds, $d->id);
        //        }
        //
        //
        //        foreach ($dungeonItemsJson as $item) {
        //            if (!in_array($item->id, $dataIds)) {
        //                $post = new objets();
        //                $post->id = $item->id;
        //                $post->libelle = strtr($item->name->fr, $unwanted_array);
        //                $post->save();
        //            }
        //        }


        $data = DB::table('objets')
            ->select('*')
            ->orderBy('libelle', 'asc')
            ->get();

        return response()->json($data);


    }
}

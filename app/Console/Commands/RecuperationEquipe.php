<?php

namespace App\Console\Commands;

use App\Models\Ligue;
use App\Models\Equipe;
use App\Models\Pays;
use App\Models\Stade;
use App\Traits\GenereObjetRequeteHttp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecuperationEquipe extends Command
{
    use GenereObjetRequeteHttp;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-equipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all the teams and associated venues\'s in a league from the API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ligue = Ligue::find(339,['id','api_ligue_id','pays_id']);
        $saison  = now();
        /*if($saison->month <= 7){
            $saison->subYear();
        }*/
        $reponse = json_decode(self::ReponseRequetHttpAPISport("https://v3.football.api-sports.io/teams?league=".$ligue->api_ligue_id."&season=".$saison->year));


        if($reponse->errors)
        {
            Log::error('Une erreur est survenue lors de la récupération des informations :'.$reponse->errors->endpoint);
        }
        else
        {
            $tableauEquipe = $reponse->response;
            if(count($tableauEquipe) > 0)
            {
                foreach($tableauEquipe as $equipe)
                {
                    $t = Equipe::updateOrCreate(
                        ['api_equipe_id' => $equipe->team->id],
                        [
                            'api_equipe_id' => $equipe->team->id,
                            'nom'           => $equipe->team->name,
                            'code'          => $equipe->team->code,
                            'pays'          => $equipe->team->country,
                            'fondation'     => $equipe->team->founded,
                            'national'      => $equipe->team->national,
                            'logo'          => $equipe->team->logo,
                            'ligue_id'      => $ligue->id,
                            'pays_id'       => $ligue->pays_id
                        ]
                    );
                    if($equipe->venue->id != null)
                    {
                        Stade::updateOrCreate(
                            ['api_stade_id' => $equipe->venue->id],
                            [
                                'api_stade_id'=> $equipe->venue->id,
                                'nom'         => $equipe->venue->name,
                                'adresse'     => $equipe->venue->address,
                                'ville'       => $equipe->venue->city,
                                'capacite'    => $equipe->venue->capacity,
                                'surface'     => $equipe->venue->surface,
                                'image'       => $equipe->venue->image,
                                'equipe_id'   => $t->id,
                            ]
                        );
                    }
                }
                //Suppression de toutes les données présentes en base qui ne sont pas dans le tableau
                $equipes = Equipe::where('ligue_id',$ligue->id)->get();
                $tableauIdEquipe = [];
                foreach ($tableauEquipe as $te) {
                    array_push($tableauIdEquipe, $te->team->id);
                }
                foreach ($equipes as $e){
                    if(!in_array($e->api_equipe_id,$tableauIdEquipe)){
                        Equipe::find($e->id)->forceDelete();
                    }
                }
            }
        }
    }
}

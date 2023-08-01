<?php

namespace App\Console\Commands;

use App\Models\Equipe;
use App\Models\Joueur;
use App\Models\Ligue;
use App\Models\PositionJoueur;
use App\Traits\GenereObjetRequeteHttp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecuperationJoueur extends Command
{
    use GenereObjetRequeteHttp;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-joueur';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all the players from a league from the API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ligue = Ligue::find(339,['id','api_ligue_id','pays_id']);
        //TODO: create a loop for all team and set a variable year which takes the current year as its value
        //Probably change the url when subscribe to API
        $saison  = now();
        /*if($saison->month <= 7){
            $saison->subYear();
        }*/


        $reponse = json_decode(self::ReponseRequetHttpAPISport("https://v3.football.api-sports.io/players?league=".$ligue->api_ligue_id."&season=".$saison->year));
        self::MajTableJoueur($reponse, $ligue);
        if($reponse->paging->total > 1)
        {
            for($i = 2; $i <= $reponse->paging->total; $i++)
            {
                $reponse = json_decode(self::ReponseRequetHttpAPISport("https://v3.football.api-sports.io/players?league=".$ligue->api_ligue_id."&season=".$saison->year."&page=".$i));
                self::MajTableJoueur($reponse, $ligue);
            }
        }
    }

    private function MajTableJoueur($reponse,$ligue)
    {
        if($reponse->errors){
            Log::error('Une erreur est survenue lors de la récupération des informations :'.$reponse->errors->endpoint);

        }else{

            $tableauJoueurs = $reponse->response;
            if (count($tableauJoueurs) > 0){
                foreach ($tableauJoueurs as $joueur){
                    $equipeID = Equipe::where('api_equipe_id',$joueur->statistics[0]->team->id)->first();
                    $j = Joueur::updateOrCreate(
                        ['api_joueur_id' => $joueur->player->id],
                        [
                            'api_joueur_id'   => $joueur->player->id,
                            'nom_complet'     => $joueur->player->name,
                            'prenom'          => $joueur->player->firstname,
                            'nom'             => $joueur->player->lastname,
                            'age'             => $joueur->player->age,
                            'date_naissance'  => $joueur->player->birth->date,
                            'ville_naissance' => $joueur->player->birth->place,
                            'pays_naissance'  => $joueur->player->birth->country,
                            'nationalite'     => $joueur->player->nationality,
                            'taille'          => $joueur->player->height,
                            'poids'           => $joueur->player->weight,
                            'blesse'          => $joueur->player->injured,
                            'photo'           => $joueur->player->photo,
                            'equipe_id'       => $equipeID->id,
                            'ligue_id'        => $ligue->id,
                            'pays_id'         => $ligue->pays_id
                        ]
                    );
                    PositionJoueur::updateOrCreate(
                        ['joueur_id' => $joueur->player->id],
                        [
                            'numero'    => $joueur->statistics[0]->games->number,
                            'position'  => $joueur->statistics[0]->games->position,
                            'joueur_id' => $j->id
                        ]
                    );
                }
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Pays;
use App\Models\Ligue;
use App\Traits\GenereObjetRequeteHttp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecuperationLigue extends Command
{
    use GenereObjetRequeteHttp;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-ligue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all the league in a country from the API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pays = Pays::all();
        foreach ($pays as $p)
        {
            $reponse = json_decode(self::ReponseRequetHttpAPISport("https://v3.football.api-sports.io/leagues?country=".$p->nom));
            if($reponse->errors){
                Log::error('Une erreur est survenue lors de la récupération des informations :'.$reponse->error->endpoint);
            }else{
                $tableauLigue = $reponse->response;
                if(count($tableauLigue) > 0){
                    foreach($tableauLigue as $ligue){
                        Ligue::updateOrCreate(
                            ['api_ligue_id' => $ligue->league->id],
                            [
                                'api_ligue_id' => $ligue->league->id,
                                'nom'      => $ligue->league->name,
                                'type'     => $ligue->league->type,
                                'logo'     => $ligue->league->logo,
                                'pays_id'  => $p->id,
                            ]
                        );
                    }
                }
            }
        }
    }
}

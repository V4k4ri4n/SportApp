<?php

namespace App\Console\Commands;

use App\Models\Pays;
use App\Traits\GenereObjetRequeteHttp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RecuperationPays extends Command
{
    use GenereObjetRequeteHttp;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-pays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Récupère toutes les données de l\'API concernant les pays et les insère dans la table countries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reponse = json_decode(self::ReponseRequetHttpAPISport('https://v3.football.api-sports.io/countries'));
        if ($reponse->errors){
            Log::error('Une erreur est survenue lors de la récupération des informations:'.$reponse->errors->endpoint);
        }else
        {
            $tabCountry = $reponse->response;
            if(count($tabCountry) > 0){
                foreach ($tabCountry as $country)
                {
                    if($country->name === "World"){
                        Pays::updateOrCreate(
                            ['nom' => "World"],
                            [
                                'nom'     => $country->name,
                                'code'    => $country->code,
                                'drapeau' => $country->flag,
                            ]
                        );
                    }else{
                        Pays::updateOrCreate(
                            [
                                'code' => $country->code,
                                'nom' => $country->name
                            ],
                            [
                                'nom'     => $country->name,
                                'code'    => $country->code,
                                'drapeau' => $country->flag,
                            ]
                        );
                    }
                }
            }
        }
    }
}

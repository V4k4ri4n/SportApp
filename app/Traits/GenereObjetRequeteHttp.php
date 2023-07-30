<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;


trait GenereObjetRequeteHttp
{
    /**
     * La fonction créée envoie vers l'api sport et récupère le corps de la réponse
     * La fonction en paramètre une route
     * La fonction retourne le corps de la réponse
     * @param String $route
     * @return string retourne uniquement le body de la réponse
     */
    public function ReponseRequetHttpAPISport(String $route)
    {
        return  Http::accept("application/json")
                ->withHeaders([
                    'x-rapidapi-host' => env('URL_API_SPORT'),
                    'x-rapidapi-key' => env('KEY_API_SPORT')
                ])
                ->get($route)
                ->body();

    }
}

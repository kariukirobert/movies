<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Abstracts\MovieAbstractClass;

class MovieController extends MovieAbstractClass //implement movie abstract class
{

    public function importTMDBMovies()
    {
        //https://api.themoviedb.org/3/movie/popular?api_key=a7b7dbaf09db337d84845049172edb7a&language=en-US&page=1
        $tmdb_url = $this->tmdb_url;
        $tmdb_api_key = $this->tmdb_api_key;
        $tmdb_lang = $this->tmdb_lang;


        $all_movies = []; //create an array to store all the movies from all pages

        for ($page=1; $page <= 5; $page++) {
            //get the movies from tmdb
            $tmdb_endpoint = $tmdb_url."/popular?api_key=".$tmdb_api_key."&".$tmdb_lang."&page=".$page;

            $client = new Client();
            $res = $client->request('GET', $tmdb_endpoint);

            $results = json_decode($res->getBody(), true);
            $all_movies[] = $results;
        }

        return $all_movies;


        // dd($tmdb_endpoint);
    }

}

<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;

class MovieService
{
    public static function getTMDBMovies($tmdb_url, $tmdb_api_key, $tmdb_lang)
    {
        $all_movies = []; //create an array to store all the movies
        for ($page=1; $page <= 5; $page++) {
            //get the movies from tmdb
            $tmdb_endpoint = $tmdb_url."/popular?api_key=".$tmdb_api_key."&".$tmdb_lang."&page=".$page;

            $client = new Client();
            $res = $client->request('GET', $tmdb_endpoint);

            $results = json_decode($res->getBody(), true);
            $all_movies = array_merge($all_movies, $results['results']);
        }

        return $all_movies;
    }

    public static function sortMovies(array $all_movies): array
    {
        # get a list of sort columns and their data to pass to array_multisort
        $sort = array();
        foreach($all_movies as $k=>$v) {
            $sort['vote_average'][$k] = $v['vote_average'];
            $sort['vote_count'][$k] = $v['vote_count'];
        }
        # sort by vote_average desc and then vote_count asc
        array_multisort($sort['vote_average'], SORT_DESC, $sort['vote_count'], SORT_DESC, $all_movies);

        return $all_movies;
    }

    public static function formatDataToSave(array $movies): array
    {
        // Get the current time
        $now = Carbon::now();

        // Formulate records that will be saved
        $movie_records = [];
        foreach ($movies as $value) {
            $movie_records[] = [
                'tmdb_id' => $value['id'],
                'title' => $value['title'],
                'vote_average' => $value['vote_average'],
                'vote_count' => $value['vote_count'],
                'updated_at' => $now,
                'created_at' => $now
            ];
        }

        return $movie_records;
    }
}

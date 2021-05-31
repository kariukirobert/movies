<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Http\Controllers\Controller;
use App\Http\Repositories\MovieRepository;

class MovieController extends Controller
{
    protected $movieRepository;
    /**
     * Class constructor.
     */
    public function __construct(MovieRepository $movieRepository)
    {
        $this->tmdb_api_key = config('app.tmdb.api_key'); //get the api key to tmdb
        $this->tmdb_url = "https://api.themoviedb.org/3/movie";
        $this->tmdb_lang = "language=en-US";

        $this->movieRepository= $movieRepository;
    }

    public function importTMDBMovies()
    {
        // Get movies from tmdb database
        $all_movies = MovieService::getTMDBMovies($this->tmdb_url, $this->tmdb_api_key, $this->tmdb_lang);

        // Sort movies
        $sorted_movies = MovieService::sortMovies($all_movies);

        // Format records that will be saved
        $formarted_data = MovieService::formatDataToSave($sorted_movies);

        # Store to the database
       $this->movieRepository->storeMovies($formarted_data);

       // return response
       return response()->json('Imported successfully', 200);
    }

}

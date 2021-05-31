<?php

namespace App\Http\Abstracts;

use App\Http\Controllers\Controller;

abstract class MovieAbstractClass extends Controller
{

    public function __construct() {
        $this->tmdb_api_key = env('TMDB_API_KEY'); //get the api key to tmdb
        $this->tmdb_url = "https://api.themoviedb.org/3/movie";
        $this->tmdb_lang = "language=en-US";
    }

    //import tmdb movies
    abstract public function importTMDBMovies();
}

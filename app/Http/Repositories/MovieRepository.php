<?php

namespace App\Http\Repositories;

use DB;
use App\Http\Interfaces\MovieInterface;

class MovieRepository implements MovieInterface
{
    public function storeMovies($data)
    {
       return DB::table('movies')->insert($data);
    }
}

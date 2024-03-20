<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Movie;

class DashcboardController extends Controller
{
   public function index(){
      $featuresMovies=Movie::whereIsFeatured(true)->get();
      $movies=Movie::all();
   

    return inertia('User/Dashboard/Index',[
      'featuresMovies' => $featuresMovies,
      'movies'=>$movies,
   ]
    );
   
   } //
}

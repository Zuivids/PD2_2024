<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Http\JsonResponse;


class DataController extends Controller
{
    // Return 3 published Films in random order
    public function getTopFilms(): JsonResponse
    {
        $films = Film::where('display', true)
            ->inRandomOrder()
            ->take(3)
            ->get();


            //Kludu parbaude
            // sleep(3)
            // $e =5/ 0;

        
        return response()->json($films);
    }
    // Return selected Film if it's published
    public function getFilm(Film $film): JsonResponse
    {
        $selectedFilm = Film::where([
                'id' => $film->id,
                'display' => true,
            ])
            ->firstOrFail();

        return response()->json($selectedFilm);
    }
    // Return 3 published Films in random order- except the selected Film
    public function getRelatedFilms(Film $film): JsonResponse
    {
        $films = Film::where('display', true)
            ->where('id', '<>', $film->id) //TODO pievient filmas ar to pashu rezisoru vai zanru
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json($films);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request\FilmRequest;
use App\Models\Producer;
use App\Models\Film;
use Illuminate\View\View;
use Illuminate\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class FilmController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }
    private function saveFilmData(Film $film, FilmRequest $request){

        $validatedData = $request->validate();

        $film>fill($validatedData);
        $film->display = (bool) ($validatedData['display'] ?? false);
        if ($request->hasFile('image')) {
            //TODO ja atjauno bildi, izdzesh veco
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $film->image =  $uploadedFile->storePubliclyAs(
                '/',
                $name . '.' . $extension,
                'uploads'
            );
        }
        $film->save();

        return redirect('/films');

    }
    // display all Films
    public function list(): View
    {
        $items = Film::orderBy('name', 'asc')->get();

        return view(
            'film.list',
            [
                'title' => 'Films',
                'items' => $items
            ]
        );
    }
    
    public function create():View
    {
        $producers = Producer::orderBy('name', 'asc')->get();
        return view(
            'film.form',
            [
                'title' => 'Add Film',
                'film' => new Film(),
                'producers' => $producers,
            ]
            );
    }
    
    public function put(FilmRequest $request): RedirectResponse
    {
        $film = new Film();
        $this->saveFilmData($film, $request);

        return redirect('/films');
    }

    // display Film edit form
    public function update(Film $film): View
    {
        $producers = Producer::orderBy('name', 'asc')->get();

        return view(
            'film.form',
            [
                'title' => 'Rediģēt grāmatu',
                'film' => $film,
                'producers' => $producers,
            ]
        );
    }

    // update Film data
    public function patch(Film $film, FilmRequest $request): RedirectResponse
    {
        $this->saveFilmData($film, $request);
        //return redirect('/films/update/' . $film->id);
        return redirect('/films');
    }

    // delete Film
    public function delete(Film $film): RedirectResponse
    {
    
        if ($film->image) {
            unlink(getcwd() . '/images/' . $film->image);
        }

        $film->delete();
        return redirect('/films');

    }

}

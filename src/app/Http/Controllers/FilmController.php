<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use App\Models\Film;
use App\Models\Genre;
use App\Http\Requests\FilmRequest;
use Illuminate\View\View;
use Illuminate\Http\Request;
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
    

    private function saveFilmData(Film $film, FilmRequest $request): void {

        $validatedData = $request->validated();
        $film->fill($validatedData);
        $film->display = (bool) ($validatedData['display'] ?? false);

        if ($request->hasFile('image')) {
            //Ja atjauno bildi, izdzesh veco
            if ($film->image) {
                unlink(getcwd() . '/images/' . $film->image);
            }
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

        //return redirect('/films');

    }

    public function create():View
    {
        $producers = Producer::orderBy('name', 'asc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();
        return view(
            'film.form',
            [
                'title' => 'Add Film',
                'film' => new Film(),
                'producers' => $producers,
                'genres' => $genres,
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
        $genres = Genre::orderBy('name', 'asc')->get();

        return view(
            'film.form',
            [
                'title' => 'Edit film',
                'film' => $film,
                'producers' => $producers,
                'genres' => $genres,
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

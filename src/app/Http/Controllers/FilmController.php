<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producer;
use App\Models\Film;
use Illuminate\View\View;
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
    
    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:256',
            'producer_id' => 'required',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'year' => 'numeric',
            'image' => 'nullable|image',
            'display' => 'nullable',
        ]);

        $film = new Film();
        $film->name = $validatedData['name'];
        $film->producer_id = $validatedData['producer_id'];
        $film->description = $validatedData['description'];
        $film->price = $validatedData['price'];
        $film->year = $validatedData['year'];
        $film->display = (bool) ($validatedData['display'] ?? false);
        if ($request->hasFile('image')) {
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
    public function patch(Film $film, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:256',
            'producer_id' => 'required',
            'description' => 'nullable',
            'price' => 'nullable|numeric',
            'year' => 'numeric',
            'image' => 'nullable|image',
            'display' => 'nullable',
        ]);

        $film->name = $validatedData['name'];
        $film->producer_id = $validatedData['producer_id'];
        $film->description = $validatedData['description'];
        $film->price = $validatedData['price'];
        $film->year = $validatedData['year'];
        $film->display = (bool) ($validatedData['display'] ?? false);
        if ($request->hasFile('image')) {
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

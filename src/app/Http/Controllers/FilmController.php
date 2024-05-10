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

}

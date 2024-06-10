<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;


class ProducerController extends Controller implements HasMiddleware
{
    
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    //display all Producers
    public function list():View
    {

        $items = Producer::orderBy('name','asc')->get();

        return view
        (
         'producer.list',
         [
            'title'=> 'Producer',
            'items'=> $items
         ]   
        );
    }

    //display new Producer form
    public function create():View
    {
        return view(
            'producer.form',
            [
                'title' => 'Add Producer',
                'producer' => new Producer,
            ]
            );
    }

    //display new Producer data
    public function put(Request $request):RedirectResponse
    {
        $validatedData = $request-> validate([
            'name'=>'required|string|max:255'
        ]);

        $producer = new Producer();
        $producer->name = $validatedData['name'];
        $producer->save();

        return redirect('/producers');
    }
    // display Producer edit form
    public function update(Producer $producer):View
    {
        return view(
            'producer.form',
            [
                'title' => 'Edit Producer',
                'producer' =>  $producer,
            ]
            );
    }

    // update Producer data
    public function patch(Producer $producer, Request $request):RedirectResponse
    {
        $validatedData = $request-> validate([
            'name'=>'required|string|max:255',
        ]);

        $producer->name = $validatedData['name'];
        $producer->save();

        return redirect('/producers');
    }
    //delete Producer data
    public function delete(Producer $producer):RedirectResponse
    {
        // šeit derētu pārbaude, kas neļauj dzēst autoru, ja tas piesaistīts eksistējošām grāmatām
       $producer->delete();
       return redirect('/producers');
    }
}

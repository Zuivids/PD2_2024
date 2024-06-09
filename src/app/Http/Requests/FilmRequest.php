<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */



    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:256',
            'producer_id' => 'required',
            'description' => 'nullable',
            //TODO Change price to raiting
            // 'price' => 'nullable|numeric',
            'rating' => 'nullable|numeric',
            'genre_id' => 'required',
            'year' => 'numeric',
            'image' => 'nullable|image',
            'display' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Lauks ":attribute" ir obligāts',
            'min' => 'Laukam ":attribute" jābūt vismaz :min simbolus garam',
            'max' => 'Lauks ":attribute" nedrīkst būt garāks par :max simboliem',
            'boolean' => 'Lauka ":attribute" vērtībai jābūt "true" vai "false"',
            'unique' => 'Šāda lauka ":attribute" vērtība jau ir reģistrēta',
            'numeric' => 'Lauka ":attribute" vērtībai jābūt skaitlim',
            'image' => 'Laukā ":attribute" jāpievieno korekts attēla fails',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'title',
            'producer_id' => 'producer',
            'genre_id' => 'genre',
            'description' => 'description',
            //'price' => 'cena',
            'rating' => 'rating',
            'year' => 'year',
            'image' => 'image',
            'display' => 'display',
        ];
    }
    
}

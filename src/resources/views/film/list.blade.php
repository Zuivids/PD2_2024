@extends('layout')

@section('content')

    <h1>{{ $title }}</h1>

    @if (count($items) > 0)

        <table class="table table-sm table-hover table-striped">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Producer</th>
                    <th>Year</th>
                    <th>Price</th>
                    <th>Display</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            @foreach($items as $film)
                <tr>
                    <td>{{ $film->id }}</td>
                    <td>{{ $film->name }}</td>
                    <td>{{ $film->producer->name }}</td>
                    <td>{{ $film->year }}</td>
                    <td>&euro; {{ number_format($film->price, 2, '.') }}</td>
                    <td>{!! $film->display ? '&#x2714;' : '&#x274C;' !!}</td>
                    <td>
                        <a
                            href="/films/update/{{ $film->id }}"
                            class="btn btn-outline-primary btn-sm"
                        >Labot</a> /
                        <form
                            method="post"
                            action="/films/delete/{{ $film->id }}"
                            class="d-inline deletion-form"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="btn btn-outline-danger btn-sm"
                            >Dzēst</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    @else
        <p>Nothing found</p>
    @endif

    <a href="/films/create" class="btn btn-primary">Add</a>

@endsection
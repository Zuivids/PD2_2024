@extends('layout')
 
@section('content')
 
    <h1>{{ $title }}</h1>
 
    @if ($errors->any())
        <div class="alert alert-danger">Lūdzu, novērsiet radušās kļūdas!</div>
    @endif
 
    <form method="post" action="{{ $producer->exists ? '/producers/patch/' . $producer->id : '/producers/put' }}">
        @csrf
 
        <div class="mb-3">
            <label for="producer-name" class="form-label">Producenta vārds</label>
 
            <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                id="producer-name" 
                name="name"
                value="{{ old('name',$producer->name)}}"    
            >
 
            @error('name')
                <p class="invalid-feedback">{{ $errors->first('name') }}</p>
            @enderror
 
        </div>
 
        <button type="submit" class="btn btn-primary">{{ $producer->exists ? 'Rediģēt' : 'Pievienot'}}</button>
 
    </form>
 
@endsection
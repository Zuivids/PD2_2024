@extends('layout')

@section('content')

    <h1>{{ $title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Please fix your mistakes!</div>
    @endif

    <form
        method="post"
        action="{{ $film->exists ? '/films/patch/' . $film->id : '/films/put' }}"
        enctype="multipart/form-data">
        @csrf


        <div class="mb-3">
            <label for="film-name" class="form-label">Name</label>

            <input
                type="text"
                id="film-name"
                name="name"
                value="{{ old('name', $film->name) }}"
                class="form-control @error('name') is-invalid @enderror"
            >

            @error('name')
                <p class="invalid-feedback">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="film-producer" class="form-label">Producers</label>

            <select
                id="film-producer"
                name="producer_id"
                class="form-select @error('producer_id') is-invalid @enderror"
            >
                <option value="">Add producer!</option>
                    @foreach($producers as $producer)
                        <option
                            value="{{ $producer->id }}"
                            @if ($producer->id == old('producer_id', $film->producer->id ?? false)) selected 
                            @endif
                        >{{ $producer->name }}</option>
                    @endforeach
            </select>

            @error('producer_id')
                <p class="invalid-feedback">{{ $errors->first('producer_id') }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="film-description" class="form-label">Description</label>

            <textarea
                id="film-description"
                name="description"
                class="form-control @error('description') is-invalid @enderror"
            >{{ old('description', $film->description) }}</textarea>

            @error('description')
                <p class="invalid-feedback">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="film-year" class="form-label">Release year</label>

            <input
                type="number" max="{{ date('Y') + 1 }}" step="1"
                id="film-year"
                name="year"
                value="{{ old('year', $film->year) }}"
                class="form-control @error('year') is-invalid @enderror"
            >

            @error('year')
                <p class="invalid-feedback">{{ $errors->first('year') }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <!-- //TODO change to rating -->
            <label for="film-price" class="form-label">Price</label>

            <input
                type="number" min="0.00" step="0.01" lang="en"
                id="film-price"
                name="price"
                value="{{ old('price', $film->price) }}"
                class="form-control @error('price') is-invalid @enderror"
            >

            @error('price')
                <p class="invalid-feedback">{{ $errors->first('price') }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="film-image" class="form-label">Cover</label>

            @if ($film->image)
                <img
                    src="{{ asset('images/' . $film->image) }}"
                    class="img-fluid img-thumbnail d-block mb-2"
                    alt="{{ $film->name }}"
                >
            @endif

            <input
                type="file" accept="image/png, image/jpeg, image/webp"
                id="film-image"
                name="image"
                class="form-control @error('image') is-invalid @enderror"
            >

            @error('image')
                <p class="invalid-feedback">{{ $errors->first('image') }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input
                    type="checkbox"
                    id="film-display"
                    name="display"
                    value="1"
                    class="form-check-input @error('display') is-invalid @enderror"
                    @if (old('display', $film->display)) checked @endif
                >
                <label class="form-check-label" for="film-display">
                    Publicēt ierakstu
                </label>

                @error('display')
                    <p class="invalid-feedback">{{ $errors->first('display') }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ $film->exists ? 'Atjaunot ierakstu' : 'Pievienot ierakstu' }}
        </button>
    </form>

@endsection

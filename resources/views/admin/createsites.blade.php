@extends('dashboard')

@section('content')
<form action="{{ $site->exists ? route('sites.update', ['site' => $site->id]) : route('sites.store') }}" method="POST">
    @csrf
    {{ $site->exists ? method_field('PUT') : '' }}

    <div class="form-group">
        <label for="name">Nom du site</label>
        <input type="text" name="site" id="name" class="form-control" value="{{ old('site', $site->site) }}" required>
    </div>

    <div class="form-group">
        <label for="address">Adresse du site</label>
        <input type="text" name="addresse" id="address" class="form-control" value="{{ old('addresse', $site->addresse) }}" required>
    </div><br>

    <button type="submit" class="btn btn-primary">{{ $site->exists ? 'Modifier le site' : 'Créer le site' }}</button>
</form>
@endsection

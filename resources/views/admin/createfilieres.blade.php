@extends('dashboard')

@section('content')
<form action="{{ $filiere->exists ? route('filieres.update ', ['filiere' => $filiere->id]) : route('filieres.store') }}" method="POST">
    @csrf
    {{ $filiere->exists ? method_field('PUT') : '' }}

    <div class="form-group">
        <label for="name">Nom des filiere</label>
        <input type="text" name="filiere" id="name" class="form-control" value="{{ old('filiere', $filiere->filiere) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">{{ $filiere->exists ? 'Modifier la filiere' : 'Créer la filiere' }}</button>
</form>
@endsection

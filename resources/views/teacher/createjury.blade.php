@extends('dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if(isset($jury))
                    <h2>Éditer le jury</h2>
                    <form action="{{ route('juries.update', ['jury' => $jury->id]) }}" method="POST">
                    @method('PUT')
                @else
                    <h2>Créer un nouveau jury</h2>
                    <form action="{{ route('juries.store') }}" method="POST">
                @endif
                    @csrf
                    <div class="form-group">
                        <label for="enseignant1">Enseignant 1</label>
                        <select class="form-control" id="enseignant1" name="enseignant1">
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" {{ isset($jury) && $jury->enseignant1->id == $enseignant->id ? 'selected' : (old('enseignant1') == $enseignant->id ? 'selected' : '') }}>{{ $enseignant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="enseignant2">Enseignant 2</label>
                        <select class="form-control" id="enseignant2" name="enseignant2">
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" {{ isset($jury) && $jury->enseignant2->id == $enseignant->id ? 'selected' : (old('enseignant2') == $enseignant->id ? 'selected' : '') }}>{{ $enseignant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="enseignant3">Enseignant 3</label>
                        <select class="form-control" id="enseignant3" name="enseignant3">
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" {{ isset($jury) && $jury->enseignant3->id == $enseignant->id ? 'selected' : (old('enseignant3') == $enseignant->id ? 'selected' : '') }}>{{ $enseignant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ isset($jury) ? 'Enregistrer les modifications' : 'Créer Jury' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

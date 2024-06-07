@extends('dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ isset($jury) ? 'Éditer le jury' : 'Créer un nouveau jury' }}</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($jury) ? route('juries.update', ['jury' => $jury->id]) : route('juries.store') }}" method="POST">
                            @csrf
                            @if(isset($jury))
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="id_filiere">Filière</label>
                                <select class="form-control" id="id_filiere" name="id_filiere" required>
                                    <option value="">Choisissez une filière</option>
                                    @foreach ($filieres as $filiere)
                                        <option value="{{ $filiere->id }}" {{ isset($jury) && $jury->id_filiere == $filiere->id ? 'selected' : '' }}>{{ $filiere->filiere }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_enseignant1">Enseignant 1</label>
                                <select class="form-control" id="id_enseignant1" name="id_enseignant1" required>
                                    <option value="">Choisissez un enseignant</option>
                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}" {{ isset($jury) && $jury->id_enseignant1 == $enseignant->id ? 'selected' : '' }}>{{ $enseignant->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_enseignant2">Enseignant 2</label>
                                <select class="form-control" id="id_enseignant2" name="id_enseignant2" required>
                                    <option value="">Choisissez un enseignant</option>
                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}" {{ isset($jury) && $jury->id_enseignant2 == $enseignant->id ? 'selected' : '' }}>{{ $enseignant->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_enseignant3">Enseignant 3</label>
                                <select class="form-control" id="id_enseignant3" name="id_enseignant3" >
                                    <option value="">Choisissez un enseignant</option>
                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{ $enseignant->id }}" {{ isset($jury) && $jury->id_enseignant3 == $enseignant->id ? 'selected' : '' }}>{{ $enseignant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-primary ">{{ isset($jury) ? 'Enregistrer les modifications' : 'Créer Jury' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

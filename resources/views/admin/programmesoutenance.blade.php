@extends('dashboard')
@section('content')

    
    <div class="container">
        <h1>Programmer les soutenances</h1>
    
        <form method="POST" action="{{ route('soutenances.programmer') }}">
            @csrf
            <div class="form-group">
                <label for="filiere_id">Filière</label>
                <select name="filiere_id" id="filiere_id" class="form-control">
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date_soutenance">Date de soutenance</label>
                <input type="date" name="date_soutenance" id="date_soutenance" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
    
        @if (isset($memoires))
            <table class="table">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Noms des binômes</th>
                        <th>Titre</th>
                        <th>Heure de soutenance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($memoires as $memoire)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $memoire->binome->etudiant1->nom }} et {{ $memoire->binome->etudiant2->nom }}</td>
                            <td>{{ $memoire->titre }}</td>
                            <td>
                                <input type="time" name="heure_soutenance_{{ $memoire->id }}" id="heure_soutenance_{{ $memoire->id }}" class="form-control">
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="programmerSoutenance({{ $memoire->id }})">Programmer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    
    <script>
    function programmerSoutenance(memoireId) {
        var heureSoutenance = document.getElementById('heure_soutenance_' + memoireId).value;
    
        // Effectuez une requête AJAX pour programmer la soutenance
        // ...
    }
    </script>
    @endsection
    
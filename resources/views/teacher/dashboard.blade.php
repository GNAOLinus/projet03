@extends('dashboard')

@section('content')
<div class="container">
    <h1>Appréciation des soutenances</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Document</th>
                <th>Appréciation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($soutenances as $soutenance)
                @if($soutenance->memoire->statut !== 'public')
                    <tr>
                        <td>{{ $soutenance->memoire->titre }}</td>
                        <td>
                            @if($soutenance->memoire->binome)
                                {{ $soutenance->memoire->binome->etudiant1->name }} et {{ $soutenance->memoire->binome->etudiant2->name }}
                            @else
                                Aucun binôme associé
                            @endif
                        </td>
                        <td>
                            <a href="{{ asset('memoires/' . $soutenance->memoire->fichier) }}">Voir le document</a>
                        </td>
                        <td>
                            <form action="{{ route('memoires.updateAppreciation', ['id' => $soutenance->id_memoire]) }}" method="post">
                                @csrf
                                @method('PUT')
                                @if(is_null($soutenance->memoire->note) || $id_edit == $soutenance->id_memoire)
                                    <div class="form-group">
                                        <select name="appreciation" class="form-control" required>
                                            <option value="">Appréciation</option>
                                            <option value="excellent" {{ $soutenance->memoire->appreciation == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                            <option value="tres_bien" {{ $soutenance->memoire->appreciation == 'tres_bien' ? 'selected' : '' }}>Très bien</option>
                                            <option value="bien" {{ $soutenance->memoire->appreciation == 'bien' ? 'selected' : '' }}>Bien</option>
                                            <option value="moyen" {{ $soutenance->memoire->appreciation == 'moyen' ? 'selected' : '' }}>Moyen</option>
                                            <option value="insuffisant" {{ $soutenance->memoire->appreciation == 'insuffisant' ? 'selected' : '' }}>Insuffisant</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="note">Note :</label>
                                        <input type="number" name="note" id="note" class="form-control" min="0" max="20" value="{{ $soutenance->memoire->note ?? '' }}" required>
                                    </div>
                                @else
                                    <span>Appréciation : {{ $soutenance->memoire->appreciation }}</span><br>
                                    <span>Note : {{ $soutenance->memoire->note }}</span>
                                @endif
                        </td>
                        <td>
                            @if (is_null($soutenance->memoire->note))
                                <button type="submit" class="btn btn-primary">Enregistrer l'appréciation</button>
                            @elseif($id_edit == $soutenance->id_memoire)
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </form>
                            @else
                                <a href="/teacher/{{$soutenance->id_memoire}}"  class="btn btn-primary">Editer l'appréciation</a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection

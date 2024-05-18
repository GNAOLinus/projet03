@extends('dashboard')

@section('content')
    <div class="container">
        <h1>Liste des mémoires</h1>
        <form action="{{route('memoire.publier')}}" method="post">
            @csrf
            <button class="btn btn-success">Publier</button>
        <br><br><br>
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Fichier</th>
                    <th>Binôme </th>
                    <th>Appréciation</th>
                    <th>Note</th>
                    <th>Sélectionner</th>
                </tr>
            </thead>
            <tbody>
                @foreach($memoires as $memoire)
                @if ($memoire->statut === null && $memoire->appreciation !== null)
                <tr>
                    <td>{{ $memoire->titre }}</td>
                    <td>{{ $memoire->resume }}</td>
                    <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">Télécharger</a></td>
                    <td>{{ $memoire->binome->etudiant1->name }} & {{ $memoire->binome->etudiant2->name }}</td>
                    <td>{{ $memoire->appreciation }}</td>
                    <td>{{ $memoire->note }}</td>
                    <td>
                        <input type="checkbox" name="memoire[]" value="{{ $memoire->id }}">
                    </td>
                </tr>
                @endif
                    
                @endforeach
            </tbody>
        </table>
    </form>
    </div>
@endsection
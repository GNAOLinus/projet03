@extends('dashboard')

@section('content')
    <div class="container">
        <h1>Liste des mémoires</h1>
        @if ($page === 'yes')
            <form action="{{ route('memoire.publier') }}" method="post">
                @csrf
                <button class="btn btn-success">Publier</button>
                <br><br><br>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Fichier</th>
                    <th>Binôme</th>
                    <th>Appréciation</th>
                    <th>Note</th>
                    @if ($page === 'yes')
                        <th>Sélectionner</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($memoires as $memoire)
                    @if ($page === 'yes')
                        @if ($memoire->statut === null && $memoire->appreciation !== null) 
                            <tr>
                                <td>{{ $memoire->titre }}</td>
                                <td>{{ $memoire->resume }}</td>
                                <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">voir le doc</a></td>
                                <td>
                                    @if($memoire->binome)
                                        {{ $memoire->binome->etudiant1->name }} & {{ $memoire->binome->etudiant2->name }}
                                    @else
                                        Aucun binôme
                                    @endif
                                </td>
                                <td>{{ $memoire->appreciation }}</td>
                                <td>{{ $memoire->note }}</td>
                                <td>
                                    <input type="checkbox" name="memoire[]" value="{{ $memoire->id }}">
                                </td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td>{{ $memoire->titre }}</td>
                            <td>{{ $memoire->resume }}</td>
                            <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">voir le doc</a></td>
                            <td>
                                @if($memoire->binome)
                                    {{ $memoire->binome->etudiant1->name }} & {{ $memoire->binome->etudiant2->name }}
                                @else
                                    Aucun binôme
                                @endif
                            </td>
                            <td>{{ $memoire->appreciation }}</td>
                            <td>{{ $memoire->note }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        @if ($page === 'yes')
            </form>
        @endif
    </div>
@endsection

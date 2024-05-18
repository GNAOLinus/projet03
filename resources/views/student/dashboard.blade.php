@extends('dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('memoire.create') }}" class="btn btn-primary @if(isset($memoire) || !isset($binome)) disabled @endif">Ajouter mémoire</a>
        </div>
        <div class="col-md-6 justify-content-end">
            <a href="{{ route('etudiants.index') }}" class="btn btn-primary @if(isset($binome)) disabled @endif">Inviter un binôme</a>
        </div>
    </div>
</div>

    @if(isset($memoire))
    <div class="container">
        <h1>Détails du mémoire</h1>
        <table class="table">
            <tbody>
                <tr>
                    <th>Titre</th>
                    <td>{{ $memoire->titre }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $memoire->resume }}</td>
                </tr>
                <tr>
                    <th>Fichier</th>
                    <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">Document</a></td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td><a href="{{ route('memoire.edit', ['memoire' => $memoire->id]) }}" class="btn btn-primary">Modifier</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    @else
    <div class="container">
        <p>Aucun mémoire trouvé.</p>
    </div>
    @endif
    
    
@endsection

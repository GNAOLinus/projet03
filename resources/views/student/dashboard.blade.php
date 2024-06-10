@extends('dashboard')
@section('content')
<div class="container">
    @if (session()->has('success'))
    <div class="alert alert-success" role="alert">
      {{ session()->get('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <a href="{{ route('memoire.create') }}" class="btn btn-primary btn-block @if(isset($memoire) || !isset($binome)) disabled @endif">Ajouter mémoire</a>
        </div>
        <div class="col-md-6 mb-2 text-md-end">
            <a href="{{ route('etudiants.index') }}" class="btn btn-primary btn-block @if(isset($binome)) disabled @endif">Inviter un binôme</a>
        </div>
    </div>

    @if(isset($memoire))
    <div class="container">
        <h1>Détails du mémoire</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row">Titre</th>
                        <td>{{ $memoire->titre }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>{{ $memoire->resume }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fichier</th>
                        <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">Document</a></td>
                    </tr>
                    <tr>
                        <th scope="row">Action</th>
                        <td>
                            <a href="{{ route('memoire.edit', ['memoire' => $memoire->id]) }}" class="btn btn-primary @if($memoire->statut === 'public') disabled @endif">Modifier</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    @else
    <div class="container">
        <p>Aucun mémoire trouvé.</p>
    </div>
    @endif
</div>
@endsection

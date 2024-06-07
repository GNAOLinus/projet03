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
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="text-center mb-4">Système de Gestion des Sites</h2>
            <div class="text-center mb-4">
                <a href="{{ route('sites.create') }}" class="btn btn-primary">Ajouter un site</a>
            </div>
            <div class="table-responsive"> <!-- Utilisation de la classe table-responsive pour les tables -->
                <table class="table table-bordered">
                    <thead class="thead-dark"> <!-- Utilisation de la classe thead-dark pour le style de l'en-tête de la table -->
                        <tr>
                            <th>Nom du Site</th>
                            <th>Adresse du Site</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sites as $site)
                        <tr>
                            <td>{{ $site->site }}</td>
                            <td>{{ $site->addresse }}</td>
                            <td>
                                <div class="btn-group" role="group"> <!-- Utilisation de la classe btn-group pour regrouper les boutons -->
                                    <a href="{{ route('sites.edit', ['site' => $site->id]) }}" class="btn btn-primary">Modifier</a>
                            
                                    <form action="{{ route('sites.destroy', ['site' => $site->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

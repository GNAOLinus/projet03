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
            <h2 class="text-center mb-4">Système de Gestion des Filières</h2>
            <div class="text-center mb-4">
                <a href="{{ route('filieres.create') }}" class="btn btn-primary">Ajouter une filière</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nom des Filières</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filieres as $filiere)
                        <tr>
                            <td>{{ $filiere->filiere }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('filieres.edit', ['filiere' => $filiere->id]) }}" class="btn btn-primary">Modifier</a>
                                    <form action="{{ route('filieres.destroy', ['filiere' => $filiere->id]) }}" method="POST">
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

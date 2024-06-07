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
    <div class="row">
        <div class="col-md-9 mx-auto">
            <h2 class="text-center">SYSTEME DE GESTION DES DIPLOMES</h2>
            @if ($diplome === 'no')
                <form action="{{ route('diplome.store') }}" method="post">
                
            @else
            <form action="{{ route('diplome.update', ['diplome' => $diplome->id]) }}" method="post">
                @method('PUT')
            @endif
            
                @csrf
                <div class="form-group">
                    <label for="diplome">Nom du Diplome</label>
                    <input type="text" class="form-control" id="diplome" name="diplome" placeholder="Entrez le nom du diplôme" @if ($diplome !== 'no')
                        value="{{ $diplome->diplome}}"
                    @endif  required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Entrez la description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Ajouter un nouveau diplôme</button>
            </form>
           
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Nom du Diplôme</th>
                        <th>Description du Diplôme</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diplomes as $diplome)
                    <tr>
                        <td>{{ $diplome->diplome }}</td>
                        <td>{{ $diplome->description }}</td>
                        <td>
                            <a href="{{ route('diplome.edit', ['diplome' => $diplome]) }}" class="btn btn-primary">Modifier</a>
                            <form action="{{ route('diplome.destroy', ['diplome' => $diplome]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

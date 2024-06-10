@extends('dashboard')

@section('content')
<main class="container mt-5">
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
    
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5>Télécharger les fichier de préinscription </h5>
        </div>
        <div class="card-body">
          <form action="{{ route('preinscription.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="fichierpreinscription">Fichier de préinscription</label>
              <input type="file" name="fichier" class="form-control-file" id="fichierpreinscription">
            </div>
            <div class="form-group mt-3">
              <select name="role" id="" class="form-control">
                <option value=""> Sélèctionner Type d'utilisteur à pré-inscrir</option>
                <option value="1">Admin</option>
                <option value="2">Etudiant </option>
                <option value="3">Enseignant</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Télécharger</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

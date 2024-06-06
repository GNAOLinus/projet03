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
          <h5>Télécharger le fichier de préinscription des etudiants</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('preinscription.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="fichierpreinscription">Fichier de préinscription</label>
              <input type="file" name="fichier" class="form-control-file" id="fichierpreinscription">
            </div>
            <button type="submit" class="btn btn-primary">Télécharger</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5>Télécharger le fichier de préinscription des enseignants</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('preinscription.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="fichierpreinscription">Fichier de préinscription</label>
              <input type="file" name="fichier" class="form-control-file" id="fichierpreinscription">
            </div>
            <input type="hidden" name="ensegnant" value="yes">
            <button type="submit" class="btn btn-primary">Télécharger</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

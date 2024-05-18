@extends('dashboard')
@section('content')
<main class="container mt-5">
    <form method="POST" action="{{ $memoire ? route('memoire.update', ['memoire' => $memoire]) : route('memoire.store') }}" enctype="multipart/form-data">
        @csrf
    @if($memoire)
        @method('PUT')
    @endif
    
        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
    <div class="form-group">
      <label for="titre">Titre du mémoire</label>
      <input type="text" name="titre" id="title" class="form-control" required value="{{ $memoire->titre ?? '' }}">
    </div>

    <div class="form-group">
      <label for="description">Description du mémoire/Resumer</label>
      <textarea name="resume" id="description" class="form-control" required>{{ $memoire->resume ?? '' }}</textarea>
    </div>

    <div class="form-group">
      <label for="fichier">Fichier du mémoire</label>
      <input type="file" name="fichier" id="file" class="form-control">
    </div>

    <div class="form-group">
      <label for="encadreur">Nom encadreur</label>
      <input type="text" name="encadreur" id="encadreur" class="form-control" required value="{{ $memoire->encadreur ?? '' }}">
    </div>

    <div class="form-group">
      <label for="promotion">Promotion</label>
      <input type="text" name="promotion" id="promotion" class="form-control" required value="{{ $memoire->promotion ?? '' }}">
    </div><br><br>

    <input type="hidden" name="statut" value="privé"> 
    <input type="hidden" name="id_binome" value="{{$binome->id}}"> 
    <input type="hidden" name="id_filiere" value="{{Auth::user()->id_filiere}}"> 
    <button type="submit" class="btn btn-primary">
      {{ $memoire ? 'Modifier le mémoire' : 'Ajouter le mémoire' }}
    </button>
  </form>
</main>
@endsection

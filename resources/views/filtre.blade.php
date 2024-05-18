@extends('layouts.base')

@section('paragraphe')
<br>
<br>

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4" id="transparant">
            <form action="{{ route('recherche.traitement') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrez le titre" value="{{ old('titre') }}">
                </div>
                <div class="form-group">
                    <label for="auteur">Auteur</label>
                    <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Entrez le nom de l'auteur" value="{{ old('auteur') }}">
                </div>
                <div class="row mt-4">
                    <div class="form-group col-md-6">
                        <label for="annee">Promotion</label>
                        <select name="promotion" class="form-control">
                            <option value="">Toutes les promotions</option>
                            @foreach($promotions as $promotion)
                            <option value="{{ $promotion }}" >{{ $promotion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="domaine">Filière</label>
                        <select class="form-control" id="filiere" name="filiere">
                            <option value="">Toutes les Filières</option>
                            @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}">{{ $filiere->filiere }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('content')
<br><br>
<div class="container">
    <div class="alert alert-danger" role="alert">
        <x-info></x-info>
    </div>
    <div class="row">
        @foreach($memoires as $memoire)
        @if($memoire->statut === 'public')
        <div class="col-md-4">
            <div class="card">
                <div class="card-head">
                    <div class="alert alert-success">
                        Mémoire {{ $memoire->id_memoire }} promotion: {{ $memoire->promotion }}
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $memoire->titre }}</h5>
                    <p class="card-text">Réaliser par :{{ $memoire->binome->etudiant1->name }} & {{ $memoire->binome->etudiant2->name }}</p>
                    <p>Appréciation : {{ $memoire->appreciation }}</p>
                    <p>Note : {{ $memoire->note }}</p>
                    
                    <a href="{{ route('memoires.previsualiser', ['memoire' => $memoire]) }}" class="btn btn-primary">Prévisualiser </a>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>

{{ $memoires->links() }}
@endsection

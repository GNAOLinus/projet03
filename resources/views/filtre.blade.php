@extends('layouts.base')

@section('paragraphe')
<br>
<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6" id="transparant">
            <form action="{{ route('recherche.traitement') }}" method="get">
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
                    <div class="form-group col-md-4">
                        <label for="annee">Promotion</label>
                        <select name="id_promotion" class="form-control">
                            <option value="">Toutes les promotions</option>
                            @foreach($promotions as $promotion)
                                <option value="{{ $promotion->id }}">{{ $promotion->promotion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="domaine">Filière</label>
                        <select class="form-control" id="filiere" name="filiere">
                            <option value="">Toutes les Filières</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->filiere }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="diplome">Appréciation</label>
                        <select name="appreciation" class="form-control">
                            <option value="">Toutes les Appréciation</option>
                            <option value="excellent" >Excellent</option>
                            <option value="tres_bien" >Très bien</option>
                            <option value="bien" >Bien</option>
                            <option value="moyen" >Moyen</option>
                            <option value="insuffisant">Insuffisant</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="diplome">Diplôme</label>
                    <select name="diplome" id="diplome" class="form-control">
                        <option value="">Tous les diplômes</option>
                        @foreach($diplomes as $diplome)
                            <option value="{{ $diplome->id }}">{{ $diplome->diplome }}</option>
                        @endforeach
                    </select>                
                </div>
                <br>
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </form>
            <br>
        </div>
    </div>
</div>
@endsection

@section('content')
<br>
<div class="container">
    <div class="alert alert-danger" role="alert">
        <x-info></x-info>
    </div>

    <div class="row">
        @foreach($memoires as $memoire)
            @if($memoire->statut === 'public')
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-head">
                        <div class="alert alert-success">
                            <p>Filière: {{ $memoire->filiere->filiere }}</p>
                            <p>Promotion: {{ $memoire->promotion->promotion }}</p>
                            <p>Document de: {{ $memoire->diplome->diplome }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $memoire->titre }}</h5>
                        <p class="card-text">Réaliser par :{{ $memoire->binome->etudiant1->name }} & {{ $memoire->binome->etudiant2->name }}</p>
                        <p>Appréciation : {{ $memoire->appreciation }}</p>
                        <p>Note : {{ $memoire->note }}</p>
                        <a href="{{ route('memoires.previsualiser', ['memoire' => $memoire, 'memoires'=> $memoires]) }}" class="btn btn-primary">Prévisualiser</a>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $memoires->links('pagination::bootstrap-5') }}
</div>
@endsection

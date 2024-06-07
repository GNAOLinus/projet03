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
        <h1>Liste des mémoires</h1>
        <div class="container">
            <form action="{{ route('recherche.traitement') }}" method="get">
                @csrf
            <div class="row">
               
                <div class="col-md-2">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrez le titre" value="{{ old('titre') }}">
                </div>
                <div class="col-md-2">
                    <label for="auteur">Auteur</label>
                    <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Entrez le nom de l'auteur" value="{{ old('auteur') }}">
                </div>
                <div class="col-md-2">
                    <label for="annee">Promotion</label>
                        <select name="id_promotion" class="form-control">
                            <option value="">Les promotions</option>
                            @foreach($promotions as $promotion)
                                <option value="{{ $promotion->id }}">{{ $promotion->promotion }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-2">
                    <label for="domaine">Filière</label>
                        <select class="form-control" id="filiere" name="filiere">
                            <option value="">Toutes les Filières</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->filiere }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-2">
                    <label for="diplome">Diplôme</label>
                    <select name="diplome" id="diplome" class="form-control">
                        <option value="">Tous les diplômes</option>
                        @foreach($diplomes as $diplome)
                            <option value="{{ $diplome->id }}">{{ $diplome->diplome }}</option>
                        @endforeach
                    </select> 
                </div>
                <div class="col-md-2">
                    <div>
                        <label for="diplome">Appréciation</label>
                        <select name="appreciation" class="form-control">
                            <option value=""> Appréciation</option>
                            <option value="excellent" >Excellent</option>
                            <option value="tres_bien" >Très bien</option>
                            <option value="bien" >Bien</option>
                            <option value="moyen" >Moyen</option>
                            <option value="insuffisant">Insuffisant</option>
                        </select>
                    </div>
                    <input type="hidden" name="admin" value="1">
                    <input type="hidden" name="page" value="{{$page}}">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </form>
                </div>
            </div>
            <br>
        </div>
        @if ($page === 'yes')
            <form action="{{ route('memoire.publier') }}" method="post">
                @csrf
                <button class="btn btn-success">Publier</button>
                <br><br><br>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>N</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Fichier</th>
                    <th>Binôme</th>
                    <th>Appréciation</th>
                    <th>Note</th>
                    @if ($page === 'yes')
                        <th>Sélectionner</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($memoires as $memoire)
                    @if ($page === 'yes')
                        @if ($memoire->statut === null && $memoire->appreciation !== null) 
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $memoire->titre }}</td>
                                <td>{{ $memoire->resume }}</td>
                                <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">voir le doc</a></td>
                                <td>
                                    @if($memoire->binome)
                                        {{ $memoire->binome->etudiant1->name }} & {{ $memoire->binome->etudiant2->name }}
                                    @else
                                        Aucun binôme
                                    @endif
                                </td>
                                <td>{{ $memoire->appreciation }}</td>
                                <td>{{ $memoire->note }}</td>
                                <td>
                                    <input type="checkbox" name="memoire[]" value="{{ $memoire->id }}">
                                </td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $memoire->titre }}</td>
                            <td>{{ $memoire->resume }}</td>
                            <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">voir le doc</a></td>
                            <td>
                                @if($memoire->binome)
                                    {{ $memoire->binome->etudiant1->name }} & {{ $memoire->binome->etudiant2->name }}
                                @else
                                    Aucun binôme
                                @endif
                            </td>
                            <td>{{ $memoire->appreciation }}</td>
                            <td>{{ $memoire->note }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        @if ($page === 'yes')
            </form>
        @endif
    </div>
@endsection

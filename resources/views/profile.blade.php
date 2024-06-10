<?php
// Vérifiez si l'utilisateur est authentifié pour choisir le bon layout
$layout = auth()->check() ? 'dashboard' : 'layouts.base';
?>

@extends($layout)

@if (!auth()->check())
    @section('titre','Bienvenue dans la banque de mémoire de ESM Bénin')
    @section('paragraphe','Pour plus d\'information, vous pouvez contacter les auteurs')
@endif

@section('content')
<br>
<br>
<br>
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
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <h5>Plus d'informations sur l'étudiant(e)</h5>
            <p>Nom : {{ $etudiant->name }}</p>
            <p>Adresse e-mail : 
                <a href="mailto:{{ $etudiant->email }}?subject=Information%20sur%20l'étudiant&body=Bonjour%20{{ urlencode($etudiant->name) }}">
                    <i class="fas fa-envelope"></i> {{ $etudiant->email }}
                </a>
            </p>
            @if($etudiant->phone)
            <p>Numéro de téléphone : 
                <a href="https://wa.me/{{ $etudiant->phone }}?text=Bonjour%20{{ urlencode($etudiant->name) }}">
                    <i class="fab fa-whatsapp"></i> {{ $etudiant->phone }}
                </a>
            </p>
            @endif
            <p>Filière : {{ $etudiant->filiere->filiere }} </p> 
            <p>Etudianat(e) de ESM : {{ $etudiant->site->site }} Addresse {{ $etudiant->site->addresse }} </p>
            <br>
            <div class="col-md-6">
                @if($etudiant->invitation === 'inviter')
                    <form action="{{ route('envoyer_invitation') }}" method="POST" class="ms-3">
                        @csrf
                        <input type="hidden" name="etudiant_id1" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
                        <button type="submit" class="btn btn-primary" aria-label="Send Invitation">Inviter</button>
                    </form>
                @elseif($etudiant->invitation === 'en_attente')
                    <form action="{{ route('confirmer_invitation') }}" method="POST" class="ms-3">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{ $etudiant->invitation_id }}">
                        <button type="submit" class="btn btn-secondary" aria-label="Confirm Invitation">Confirmer</button>
                    </form>
                @elseif($etudiant->invitation === 'envoyée')
                    <button type="button" class="btn btn-warning ms-3" disabled aria-label="Invitation Sent">Invitation envoyée</button>
                @endif
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
@endsection

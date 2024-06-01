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
            @if($invitation === 'inviter')
            <!-- Formulaire pour envoyer une invitation -->
            <form action="{{ route('envoyer_invitation') }}" method="post" class="ms-3">
                @csrf
                <input type="hidden" name="etudiant_id1" value="{{ auth()->user()->id }}">
                <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">

                <button type="submit" class="btn btn-primary">Inviter</button>
            </form>
            @elseif($invitation === 'en_attente')
            <!-- Formulaire pour permettre à l'utilisateur connecté de confirmer l'invitation reçue -->
            <form action="{{ route('confirmer_invitation') }}" method="post" class="ms-3">
                @csrf
                <input type="hidden" name="invitation_id" value="{{ $invitation_id }}">
                <button type="submit" class="btn btn-secondary">Confirmer</button>
            </form>
            @elseif($invitation === 'envoyée')
            <!-- Bouton désactivé pour indiquer que l'invitation a été envoyée par l'utilisateur connecté -->
            <button type="button" class="btn btn-warning ms-3" disabled>Invitation envoyée</button>
            @endif
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
@endsection

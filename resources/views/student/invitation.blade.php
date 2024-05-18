@extends('dashboard')
@section('content')
<main class="container mt-5">
    @foreach($etudiants_sans_binome as $etudiant)
        @if ($etudiant->id !== auth()->user()->id) <!-- Vérifier si l'étudiant n'est pas l'utilisateur actuellement authentifié -->
            <div class="d-flex align-items-center mb-3">
                <span>{{ $etudiant->name }}</span>
                @if($etudiant->invitation === 'inviter')
                    <!-- Formulaire pour envoyer une invitation -->
                    <form action="{{ route('envoyer_invitation') }}" method="post" class="ms-3">
                        @csrf
                        <input type="hidden" name="etudiant_id1" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">

                        <button type="submit" class="btn btn-primary">Inviter</button>
                    </form>
                @elseif($etudiant->invitation === 'en_attente')
                    <!-- Formulaire pour permettre à l'utilisateur connecté de confirmer l'invitation reçue -->
                    <form action="{{ route('confirmer_invitation') }}" method="post" class="ms-3">
                        @csrf
                        <input type="hidden" name="invitation_id" value="{{$etudiant->invitation_id}}">
                        <button type="submit" class="btn btn-secondary">Confirmer</button>
                    </form>
                    
                    
                @elseif($etudiant->invitation === 'envoyée')
                    <!-- Bouton désactivé pour indiquer que l'invitation a été envoyée par l'utilisateur connecté -->
                    <button type="button" class="btn btn-warning ms-3" disabled>Invitation envoyée</button>
                @endif
            </div>
        @endif
    @endforeach
</main>
@endsection

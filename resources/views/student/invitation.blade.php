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
    <div>
        <form class="d-flex" action="{{ route('etudiant.recherche') }}" method="GET">
            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    <br>
    @foreach($etudiants_sans_binome as $etudiant)
        @if ($etudiant->id !== auth()->user()->id)
            <div class="d-flex align-items-center mb-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('profile') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $etudiant->id }}">
                                <input type="hidden" name="invitation" value="{{ $etudiant->invitation }}">
                                <button type="submit" class="btn btn-link">{{ $etudiant->name }}</button>
                            </form>
                        </div>
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
                </div>
            </div>
        @endif
    @endforeach
    @if ($etudiants_sans_binome->isNotEmpty())
        <div class="d-flex justify-content-center">
            {{ $etudiants_sans_binome->links() }}
        </div>
    @endif
</main>
@endsection

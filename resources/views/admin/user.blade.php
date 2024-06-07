@extends('dashboard')
@section('content')
<div class="container">
    <br>
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
        <form class="d-flex" action="{{ route('user.recherche') }}" method="GET">
            @csrf
            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
    </div>
    <div class="row">

        <div class="col-md-9">
            <h2 style="text-align: center;">Système de gestion des utilisateurs</h2>
            <table class="table table-bordered">
                <tr>
                    <th>NOM </th>
                    <th> role</th>
                    <th>Address</th>
                    <th>numero de téléphone</th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role->role }}</td>
                    <td>
                        <a href="mailto:{{ $user->email }}?subject=Information%20sur%20l'étudiant&body=Bonjour%20{{ urlencode($user->name) }}">
                            <i class="fas fa-envelope"></i> {{ $user->email }}
                        </a>
                    </td>
                    <td>
                        <a href="https://wa.me/{{ $user->phone }}?text=Bonjour%20{{ urlencode($user->name) }}">
                            <i class="fab fa-whatsapp"></i> {{ $user->phone }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
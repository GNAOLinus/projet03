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
   
            <h2 style="text-align: center;">SYSTEME DE GESTION DES BIÔMES</h2>
            <div class="container">
                
                    <form action="{{route('recherche.binomes')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="titre">Noms d'un Etudiant</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Entrez le Noms" value="{{ old('name') }}">
                                </div>
                                <div class="col-md-2">
                                   <br>
                                    <button type="submit" class="btn btn-primary ">Rechercher</button>
                                </div>
                            
                            </div>
                        </div>
                    </form>
            </div>
<br>
   

<a href="{{ route('binomes.create') }}" class="btn btn-primary">Ajouter un binôme</a>
<br><br>
<br>

            <table class="table table-bordered">

                <tr>

                    <th>N</th>

                    <th> Nom des étudiants</th>

                    <th>filière</th>

                    <th>ACTIONS</th>

                </tr>

                @foreach($binomes as $binome)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $binome->etudiant1->name . ' & ' . $binome->etudiant2->name }}</td>
                    <td>{{ $binome->filiere->filiere }}</td>
                    <td>
                        <form action="{{ route('binomes.destroy', ['binome' => $binome->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
            </table>
</div>

@endsection
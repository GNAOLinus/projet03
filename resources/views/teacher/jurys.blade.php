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
        <div class="row">
            <div class="col-md-12">
                <h2 style="text-align: center;">Liste des jurys</h2>
                <div class="container">
                
                    <form action="{{route('juries.recherche')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                    <label for="titre">Noms d'un Enseignant</label>
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

                <table class="table mt-5">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Enseignant 1</th>
                            <th>Enseignant 2</th>
                            <th>Enseignant 3</th>
                            <th>Actions</th> <!-- Ajout de la colonne des actions -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($juries as $jury)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $jury->enseignant1->name }}</td>
                            <td>{{ $jury->enseignant2->name }}</td>
                            <td>@if ($jury->id_enseignant3 === null)
                                <p>Non definit</p>
                            @else
                                {{ $jury->enseignant3->name }}</td>
                            @endif
                                
                                
                            <td>
                                <a href="{{ route('juries.edit', ['jury' => $jury->id]) }}" class="btn btn-primary">Modifier</a>
                                <form action="{{ route('juries.destroy', ['jury' => $jury->id]) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Liste des jurys</h2>
   
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Enseignant 1</th>
                            <th>Enseignant 2</th>
                            <th>Enseignant 3</th>
                            <th>Actions</th> <!-- Ajout de la colonne des actions -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($juries as $jury)
                        <tr>
                            <td>{{ $jury->id }}</td>
                            <td>{{ $jury->enseignant1->name }}</td>
                            <td>{{ $jury->enseignant2->name }}</td>
                            <td>{{ $jury->enseignant3->name }}</td>
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

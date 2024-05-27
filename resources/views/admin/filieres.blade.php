@extends('dashboard')
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-9">
            <h2 style="text-align: center;">SYSTEME DE GESTION DES FILIERES</h2>
            <a href="{{ route('filieres.create') }}" class="btn btn-primary">Ajouter un filiere</a><br>
            <table class="table table-bordered">
                <tr>
                    <th>Nom des filieres</th>
                    
                    <th>ACTIONS</th>
                </tr>
                @foreach($filieres as $filiere)
                <tr>
                    <td>{{ $filiere->filiere }}</td>
                    
                    <td>
                        <a href="{{ route('filieres.edit', ['filiere' => $filiere->id]) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('filieres.destroy', ['filiere' => $filiere->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
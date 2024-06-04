@extends('dashboard')
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-9">
            <h2 style="text-align: center;">SYSTEME DE GESTION DES DIPLOME </h2>
            <form action="{{ route('diplome.store') }}" method="post">
                <input type="text">
                <textarea name="desciption" id="" cols="5" rows="5"></textarea>
                <button type="submit" class="btn btn-primary">Ajouter un nouveau diplome</button>
            </form>
           
            <table class="table table-bordered">
                <tr>
                    <th>Nom du Diplomes</th>
                    <th>desciption du Diplomes</th>
                    <th>ACTIONS</th>
                </tr>
                @foreach($diplomes as $diplome)
                <tr>
                    <td>{{ $diplome->diplome }}</td>
                    
                    <td>
                        <a href="{{ route('diplome.edit', ['diplome' => $diplome->id]) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('diplome.destroy', ['diplome' => $diplome->id]) }}" method="POST">
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
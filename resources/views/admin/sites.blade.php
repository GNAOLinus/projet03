@extends('dashboard')
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-9">
            <h2 style="text-align: center;">SYSTEME DE GESTION DES SITES</h2>
            <a href="{{ route('sites.create') }}" class="btn btn-primary">Ajouter un site</a><br>
            <table class="table table-bordered">
                <tr>
                    <th>NOM DU SITE</th>
                    <th>ADRESSE DU SITE</th>
                    <th>ACTIONS</th>
                </tr>
                @foreach($sites as $site)
                <tr>
                    <td>{{ $site->site }}</td>
                    <td>{{ $site->addresse }}</td>
                    <td>
                        <a href="{{ route('sites.edit', ['site' => $site->id]) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('sites.destroy', ['site' => $site->id]) }}" method="POST">
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
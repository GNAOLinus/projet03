@extends('dashboard')
@section('content')
<div class="container">

    <div class="row">

        <div class="col-md-9">

            <h2 style="text-align: center;">SYSTEME DE GESTION DES Biômes</h2>

            <a href="{{ route('binomes.create') }}" class="btn btn-primary">Ajouter un binôme</a>

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
                        <a href="{{ route('binomes.edit',['binome' => $binome->id_binome]) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('binomes.destroy', ['binome' => $binome->id_binome]) }}" method="POST">
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
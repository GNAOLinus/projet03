@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h1>Gestion des Mémoires Publiés</h1>

    <div class="row">
        @foreach ($filieres as $filiere)
            <div class="col-md-6"> <!-- Utilisation de col-md-6 pour afficher deux colonnes par ligne sur les petits écrans -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2>{{ $filiere->filiere }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"> <!-- Utilisation de table-responsive pour rendre la table adaptative -->
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Titre</th>
                                        <th>Résumé</th>
                                        <th>Noms des Binômes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($memoires as $memoire)
                                        @if ($memoire->id_filiere === $filiere->id)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $memoire->titre }}</td>
                                                <td>{{ substr($memoire->resume, 0, 50) }}</td>
                                                <td>{{ $memoire->binome->etudiant1->name }} et {{ $memoire->binome->etudiant2->name }}</td>
                                                <td>
                                                    <form action="" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $memoire->id }}">
                                                        <button type="submit" class="btn btn-danger">Retirer</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

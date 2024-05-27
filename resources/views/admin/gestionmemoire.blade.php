@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h1>Gestion des Mémoires Publiés</h1>

    @foreach ($filieres as $filiere)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2>{{ $filiere->filiere }}</h2>
            </div>
            <div class="card-body">
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
                        @foreach ($memoires as $memoire)
                            @if ($memoire->id_filiere === $filiere->id)
                            @php
                                $i=1;
                            @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $memoire->titre }}</td>
                                    <td>{{ $memoire->resume }}</td>
                                    <td>{{ $memoire->binome->etudiant1->name }} et {{ $memoire->binome->etudiant2->name }}</td>
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $memoire->id }}">
                                            <button type="submit" class="btn btn-danger">Retirer</button>
                                        </form>
                                    </td>
                                    @php
                                        $i++
                                    @endphp
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection

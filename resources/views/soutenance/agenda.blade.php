@extends('dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Liste des soutenances</div>
                    @foreach ($filieres as $filiere)
                        <h3> {{$filiere->filiere}} </h3>
                    @endforeach
                <div class="card-body">
                   
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mémoire</th>
                                <th>Site</th>
                                <th>Date de soutenance</th>
                                <th>Heure de soutenance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($soutenances as $soutenance)
                                <tr>
                                    <td>{{ $soutenance->id }}</td>
                                    <td>{{ $soutenance->memoire->titre }}</td>
                                    <td>{{ $soutenance->site->site }}</td>
                                    <td>{{ $soutenance->date_soutenance }}</td>
                                    <td>{{ $soutenance->heurs_soutenance }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

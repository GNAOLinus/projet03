@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Liste des soutenances</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mémoire</th>
                                <th>Appréciation</th>
                                <th>Site</th>
                                <th>Date de soutenance</th>
                                <th>Heure de soutenance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($soutenances as $soutenance)
                                <tr>
                                    <td>{{ $soutenance->id_soutenance }}</td>
                                    <td>{{ $soutenance->memoire->titre }}</td>
                                    <td>{{ $soutenance->appreciation->libelle }}</td>
                                    <td>{{ $soutenance->site->site }}</td>
                                    <td>{{ $soutenance->date_soutenance }}</td>
                                    <td>{{ $soutenance->heurs_soutenace }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

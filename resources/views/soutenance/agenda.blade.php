@extends('dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agenda des soutenances</div>

                <div class="card-body">
                    <div class="row">
                        @foreach ($filieres as $filiere)
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $filiere->filiere }}</h5>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>N</th>
                                                    <th>Mémoire</th>
                                                    <th>Site</th>
                                                    <th>Date de soutenance</th>
                                                    <th>Heure de soutenance</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($soutenances ->where('id_memoire', $filiere->id) as $soutenance)
                                                    <tr>
                                                        <td>{{ $soutenance->id_soutenance }}</td>
                                                        <td>{{ $soutenance->date_soutenance }}</td>
                                                        <td>{{ $soutenance->heurs_soutenace }}</td>
                                                        <td>
                                                            <a href="{{ route('soutenances.edit', $soutenance->id_soutenance) }}" class="btn btn-primary">Modifier</a>
                                                            <form action="{{ route('soutenances.destroy', $soutenance->id_soutenance) }}" method="POST" class="d-inline">
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

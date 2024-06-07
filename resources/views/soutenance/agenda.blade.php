@extends('dashboard')

@section('content')
<div class="container">
    @if (session()->has('success'))
    <div class="alert alert-success" role="alert">
      {{ session()->get('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif
    <div class="row justify-content-center">
        <div class="col-md-10">
           
                <h3 style="text-align: center;">Liste des soutenances</h3>
                    @foreach ($filieres as $filiere)
                    <div class="card">
                        <div class="card-header">
                            <h4 style="text-align: center;"> {{$filiere->filiere}} </h4>
                        </div>
                        <div class="card-body">
                   
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N</th>
                                        <th>Mémoire</th>
                                        <th>Site</th>
                                        <th>Date de soutenance</th>
                                        <th>Heure de soutenance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($soutenances as $soutenance)
                                    @if ($soutenance->id_filiere ===$filiere->id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $soutenance->memoire->titre }}</td>
                                        <td>{{ $soutenance->site->site }}</td>
                                        <td>{{ $soutenance->date_soutenance }}</td>
                                        <td>{{ $soutenance->heurs_soutenance }}</td>
                                    </tr>
                                    @else
                                        <p>Aucune soutenace programmer pour la {{$filiere->filiere}}</p>
                                    @endif
                                       
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="d-flex justify-content-center"></div>
                        </div>
                    </div>
                        <br><br><br>
                    @endforeach
        </div>
    </div>
</div>
@endsection

@extends('dashboard')

@section('content')
    <div class="container">
        <h1>Programmer les Soutenances</h1>
        <form action="{{route('soutenances.store')}}" method="post" id="soutenance-form">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_filiere">Filière</label>
                        <select name="id_filiere" id="id_filiere" class="form-control" required onchange="suggestion(this.value)">
                            <option value="">Sélectionner une filière</option>
                            @foreach ($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->filiere }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_jury">Jury</label>
                        <select name="id_jury" id="jury_id" class="form-control" required>
                            <option value="">Choisir un jury</option>
                            @foreach ($jurys as $jury)
                                <option value="{{ $jury->id }}">{{ $jury->id_enseignant1}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_site">Site</label>
                        <select name="id_site" id="site_id" class="form-control" required>
                            <option value="">Choisir un site</option>
                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}">{{ $site->site }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" class="form-control" name="date_soutenance" required>
                    </div>
                </div>
            </div>
<br>
            <table class="table" id="soutenances-table">
                <thead>
                    <tr>
                        <th>N</th>
                        <th>Binôme</th>
                        <th>Mémoire</th>
                        <th>Heure de début</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </form>
    </div>

    <script>
    function suggestion(id_filiere) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const memoires = JSON.parse(this.responseText);
            let optionsHtml = '';
            var tableBody = document.querySelector('#soutenances-table tbody');
            tableBody.innerHTML = '';
            if (Array.isArray(memoires)) {
                memoires.forEach(function(memoire, index) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${memoire.id_binome}</td>
                        <td>${memoire.titre}</td>
                        <td><input type="time" name="heurs_soutenace" class="form-control" required></td>
                        <td>
                            <input type="hidden" name="id_memoire" value="${memoire.id}">
                            <button class="btn btn-success">Programmer</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                console.log('La réponse n\'est pas un tableau valide.');
            }
        }
    };
    xmlhttp.open("GET", "http://127.0.0.1:8000/soutenances/filiere/" + id_filiere, true);
    xmlhttp.send();
}

    </script>
@endsection

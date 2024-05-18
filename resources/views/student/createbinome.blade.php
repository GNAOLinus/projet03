@extends('dashboard')

@section('content')
<main class="container mt-5">
    <form action="{{ route('binomes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_filiere">Filière</label>
            <select name="id_filiere" id="id_filiere" onchange='suggestion(this.value)' class="form-control">
                <option value="">Sélectionnez une filière</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->filiere }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="etudiant1">Etudiant: 1</label>
            <select name="id_etudiant1" class="form-control" id="etudiant1">
                <option value="#">Sélectionnez une filiere d'abore </option>
            </select>
        </div>

        <div class="form-group">
            <label for="etudiant2">Etudiant: 2</label>
            <select name="id_etudiant2" class="form-control" id="etudiant2">
                <option value="#">Sélectionnez une filiere d'abore </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Créer le binôme</button>
    </form>
</main>

<script>
    function suggestion(idFiliere) {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const etudiants = JSON.parse(this.responseText);
                let optionsHtml = '';
                etudiants.forEach(function(etudiant) {
                    optionsHtml += `<option value="${etudiant.id}">${etudiant.name}</option>`;
                });
                document.getElementById('etudiant1').innerHTML = optionsHtml;
                document.getElementById('etudiant2').innerHTML = optionsHtml; // Répète pour le deuxième sélecteur d'étudiant
            }
        };
        xmlhttp.open("GET", "http://127.0.0.1:8000/etudiants/" + idFiliere, true);
        xmlhttp.send();
    }
</script>
@endsection

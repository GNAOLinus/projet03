@extends('dashboard')
@section('content')
<div class="container">
    <h1 style="text-align: center;">Programmer les Soutenances</h1>
    <div id="error-container"></div>

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

    <div class="row">
        <div class="col-md-6">
            <!-- Formulaire pour sélectionner la filière, le jury et le site -->
            <div class="form-group">
                <label for="id_filiere">Filière</label>
                <select name="id_filiere" id="id_filiere" class="form-control" required onchange="getMemoires(this.value)">
                    <option value="">Sélectionner une filière</option>
                    @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ old('id_filiere') == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->filiere }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_jury">Jury</label>
                <select name="id_jury" id="id_jury" class="form-control" required>
                    <option value="">Choisir un jury</option>
                    @foreach ($jurys as $jury)
                    <option value="{{ $jury->id }}" {{ old('id_jury') == $jury->id ? 'selected' : '' }}>
                        {{ $jury->enseignant1->name }}/{{ $jury->enseignant2->name }}/@if ($jury->id_enseignant3 === null)
                        <p>Non definit</p>/{{ $jury->filiere->filiere }}
                    @else
                        {{ $jury->enseignant3->name }}</td>
                    @endif
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="id_site">Site</label>
                <select name="id_site" id="id_site" class="form-control" required>
                    <option value="">Choisir un site</option>
                    @foreach ($sites as $site)
                    <option value="{{ $site->id }}" {{ old('id_site') == $site->id ? 'selected' : '' }}>
                        {{ $site->site }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" class="form-control" name="date_soutenance" value="{{ old('date_soutenance') }}" required>
            </div>
        </div>
    </div>

    <br>

    <form id="soutenance-form">
        @csrf
        <!-- Tableau pour afficher les mémoires et programmer les soutenances -->
        <table class="table" id="soutenances-table">
            <thead>
                <tr>
                    <th>N</th>
                    <th>Titre</th>
                    <th>Binôme</th>
                    <th>Heure de début</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="soutenances-tbody">
            </tbody>
        </table>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('soutenance-form');
        const idFiliere = document.getElementById('id_filiere');
        const idJury = document.getElementById('id_jury');
        const idSite = document.getElementById('id_site');
        const dateSoutenance = document.getElementById('date');
        const heureSoutenance = document.getElementById('heurs_soutenance'); // Ajouter cette ligne


        form.addEventListener('submit', function(event) {
            event.preventDefault();
            submitMemoireData();
        });

    
        
    });

       // Soumettre les données du formulaire pour programmer une soutenance
       async function soumettreMemoire(formData) {
        try {
            
            const response = await fetch("{{ route('soutenances.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            // Vérifier si la réponse est OK
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Erreur lors de la requête HTTP : ${response.status}`);
            }

            // Vérifier si la réponse est au format JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.indexOf('application/json') !== -1) {
                const data = await response.json();
                console.log('Succès : ', data);
                // Optionnellement, afficher un message de succès ou rediriger l'utilisateur
            } else {
                const text = await response.text();
                throw new Error('Réponse non-JSON reçue : ' + text);
            }
        } catch (error) {
            console.error('Erreur de connexion : ', error);
        }
    }
    // Soumettre les données du formulaire lors du clic sur le bouton "Programmer"
    function submitMemoireData() {
        const form = document.getElementById('soutenance-form');
        const formData = new FormData(form);
        // Ajouter les valeurs de date et d'heure de début à formData
        formData.append('heurs_soutenance', document.getElementById('heurs_soutenance').value);
        formData.append('date_soutenance', document.getElementById('date').value);
        formData.append('id_filiere', document.getElementById('id_filiere').value);
        formData.append('id_jury', document.getElementById('id_jury').value);
        formData.append('id_site', document.getElementById('id_site').value);

    soumettreMemoire(formData);
    }
    // Récupérer les mémoires de la filière sélectionnée
    async function getMemoires(idFiliere) {
        try {
            const response = await fetch(`/soutenances/filiere/${idFiliere}`);
            const memoires = await response.json();
            const tbody = document.getElementById('soutenances-tbody');
            tbody.innerHTML = ''; // Vider les lignes existantes

            console.log(memoires); // Pour débogage, voir les données des mémoires

            for (let index = 0; index < memoires.length; index++) {
                const memoire = memoires[index];
                let binomeText = 'Aucun binôme associé';

                // Récupérer les données du binôme si disponible
                if (memoire.id_binome) {
                    try {
                        const binomeResponse = await fetch(`/soutenances/binome/${memoire.id_binome}`);
                        const binome = await binomeResponse.json();
                        if (binome.etudiant1 && binome.etudiant2) {
                            binomeText = `${binome.etudiant1.name} et ${binome.etudiant2.name}`;
                        }
                    } catch (error) {
                        console.error(`Erreur lors de la récupération des données du binôme: ${error}`);
                    }
                }

                // Créer une ligne dans le tableau pour chaque mémoire
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${memoire.titre}</td>
                    <td>${binomeText}</td>
                    <td>
                        <input type="time" id='heurs_soutenance' name="heurs_soutenance" class="form-control" required>
                    </td>
                    <td>
                        <input type="hidden" name="id_memoire" value="${memoire.id}" id="'id_memoire'">
                        <button type="button" onclick="submitMemoireData()" class="btn btn-success">Programmer</button>
                    </td>
                `;
                tbody.appendChild(row);
            }
        } catch (error) {
            console.error(`Erreur lors de la récupération des mémoires: ${error}`);
        }
    }


    
</script>

@endsection


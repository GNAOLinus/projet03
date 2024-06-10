@extends('dashboard')

@section('content')
<main class="container mt-5">
    <div class="row">
        <!-- Gestion des mémoires -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Gestion des mémoires</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('memoire.allmemoire', ['page' => 'yes']) }}" class="btn btn-primary w-100">Publier des mémoires</a></li>
                        <li class="list-group-item"><a href="{{ route('memoirepublier') }}" class="btn btn-primary w-100">Gérer les mémoires publiées</a></li>
                        <li class="list-group-item"><a href="{{ route('memoire.allmemoire', ['page' => 'no']) }}" class="btn btn-primary w-100">Liste des mémoires</a></li>
                        @if (Auth::user()->id_role == 4)
                            <li class="list-group-item"><a href="{{ route('preinscription') }}" class="btn btn-primary w-100">Pré-inscription</a></li>
                            <li class="list-group-item"><a href="{{ route('diplome.index') }}" class="btn btn-primary w-100">Les diplômes</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 mb-4">
            <div class="container">
                <!-- Gestion des soutenances -->
                <div class="card">
                    <div class="card-header">Gestion des soutenances</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a href="{{ route('soutenances.index') }}" class="btn btn-primary w-100">Programmer les soutenances</a></li>
                            <li class="list-group-item"><a href="{{ route('agenda') }}" class="btn btn-secondary w-100">Gestion des calendriers</a></li>
                        </ul>
                    </div>
                </div>
                 <!-- Gestion des jurys -->
                <div class="card mt-2">
                    <div class="card-header">Gestion des jurys</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a href="{{ route('juries.create') }}" class="btn btn-primary w-100">Créer un jury</a></li>
                            <li class="list-group-item"><a href="{{ route('juries.index') }}" class="btn btn-light w-100">Liste des jurys</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="row">
       
        <!-- Gestion des binômes -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Gestion des binômes</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('binomes.create') }}" class="btn btn-primary w-100">Créer un binôme</a></li>
                        <li class="list-group-item"><a href="{{ route('binomes.index') }}" class="btn btn-light w-100">Liste des binômes</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @if (Auth::user()->id_role == 4)
        <!-- Gestion des sites ESM-Bénin -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Gestion des Sites ESM-Bénin</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('sites.index') }}" class="btn btn-primary w-100">Gestion des sites de ESM-Bénin</a></li>
                        <li class="list-group-item"><a href="{{ route('filieres.index') }}" class="btn btn-secondary w-100">Gestion des filières de ESM-Bénin</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if (Auth::user()->id_role == 4)
    <div class="row">
      
        <!-- Copier le lien pour -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">Copier le lien pour :</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <select name="id_promotion" id="id_promotion" class="form-control mb-3">
                                <option value="">Sélectionner une promotion</option>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}">{{ $promotion->promotion }}</option>
                                @endforeach
                            </select>
                            <select name="id_diplome" id="id_diplome" class="form-control">
                                <option value="">Diplôme pour les étudiants</option>
                                @foreach ($diplomes as $diplome)
                                    <option value="{{ $diplome->id }}">{{ $diplome->diplome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('promotion.store') }}" method="post">
                                @csrf
                                <input type="text" name="promotion" class="form-control mb-3" placeholder="Nouvelle promotion">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100">Créer</button>
                            </form>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush mt-3" id="copie-lien">
                        @foreach (['Administrateur', 'Etudiant', 'Enseignant'] as $index => $role)
                            <li class="list-group-item d-flex align-items-center">
                                <button class="btn btn-primary copy-button me-2" data-role="{{ $index + 1 }}">Ajouter un(e) {{ ucfirst($role) }}</button>
                                <input type="text" class="link-input form-control" style="display: none;">
                            </li>
                        @endforeach
                        <li class="list-group-item">
                            <a href="{{ route('users') }}" class="btn btn-light w-100">Liste des utilisateurs</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var promotionSelect = document.getElementById('id_promotion');
        var diplomeSelect = document.getElementById('id_diplome');
        var copyButtons = document.querySelectorAll('.copy-button');

        function toggleCopyButtons() {
            var selectedPromotion = promotionSelect.value;
            var selectedDiplome = diplomeSelect.value;

            copyButtons.forEach(function(button) {
                var role = button.getAttribute('data-role');
                button.disabled = selectedPromotion === '' || (role === '2' && selectedDiplome === '');
            });
        }

        promotionSelect.addEventListener('change', toggleCopyButtons);
        diplomeSelect.addEventListener('change', toggleCopyButtons);
        toggleCopyButtons();

        copyButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var selectedPromotion = promotionSelect.value;
                var selectedDiplome = diplomeSelect.value;
                var role = this.getAttribute('data-role');

                if (selectedPromotion === '' || (role === '2' && selectedDiplome === '')) {
                    alert('Veuillez sélectionner une promotion et un diplôme (pour les étudiants) avant de copier le lien.');
                    return;
                }

                var input = this.parentNode.querySelector('.link-input');
                var url = `/generate-link/${role}/${selectedPromotion}`;
                if (role === '2') {
                    url += `/${selectedDiplome}`;
                } else {
                    url += `/0`;
                }
                console.log(url);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        var link = data.link;
                        console.log(link);

                        input.value = link;
                        input.style.display = 'block';
                        input.select();
                        document.execCommand('copy');
                        input.style.display = 'none';
                        alert('Lien copié dans le presse-papiers !');
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des données:', error);
                        alert('Une erreur s\'est produite lors de la récupération des données.');
                    });
            });
        });
    });
</script>
@endsection

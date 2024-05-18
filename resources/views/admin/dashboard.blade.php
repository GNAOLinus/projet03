@extends('dashboard')

@section('content')
<main class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestion des mémoires
                </div>
                <div class="card-body">
                    <ul class="list-group listmemoire.allmemoire-group-flush">
                        <li class="list-group-item">
                            <a href="{{route('memoire.allmemoire')}}" class="btn btn-primary">Publier des mémoires</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="btn btn-primary">Gérer les mémoires publiées</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('memoire.allmemoire')}}" class="btn btn-primary">Liste des mémoires</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Copier le lien pour :
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <select name="id_promotion" id="id_promotion" class="form-control">
                            <option value="">Sélectionner une promotion</option>
                            @foreach ($promotions as $promotion)
                            <option value="{{$promotion->id}}">{{$promotion->promotion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <form action="{{route('promotion.store')}}" method="post">
                            @csrf
                            <input type="text" name="promotion" class="form-control" placeholder="Nouvelle promotion">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary">Créer</button>
                    </form>
                    </div>
                </div>
               
                <div class="card-body">
                    <ul class="list-group list-group-flush" id="copie-lien">
                        @foreach (['Administrateur', 'Etudiant', 'Enseignant'] as $index => $role)
                        <li class="list-group-item">
                            <button class="btn btn-primary copy-button" data-role="{{ $index + 1 }}">Ajouter un(e) {{ ucfirst($role) }}</button>
                            <input type="text" class="link-input form-control" style="display: none;">
                        </li>
                        
                        @endforeach
                        <li class="list-group-item">
                            <a href="{{route('users')}}" class="btn btn-light">Liste des utilisateurs</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestion des jurys
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('juries.create') }}" class="btn btn-primary">Créer un jury</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('juries.index') }}" class="btn btn-light">Liste des jurys</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestion des binômes
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('binomes.create') }}" class="btn btn-primary">Créer un binôme</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('binomes.index') }}" class="btn btn-light">Liste des binômes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestion des Sites ESM-Bénin
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('sites.index') }}" class="btn btn-primary">Gestion des sites de ESM-Bénin</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('filieres.index') }}" class="btn btn-secondary">Gestion des filières de ESM-Bénin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestion des soutenances 
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{route('soutenances.index')}}" class="btn btn-primary">Programmer les soutenances</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('agenda')}}" class="btn btn-secondary">Gestion des calendriers</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>   
</main>
<script>
    document.getElementById('id_promotion').addEventListener('change', function() {
        var selectedPromotion = this.value;
        var buttons = document.querySelectorAll('.copy-button');
        
        buttons.forEach(function(button) {
            button.disabled = selectedPromotion === '';
        });
    });

    document.querySelectorAll('.copy-button').forEach(function(button) {
        button.addEventListener('click', function() {
            var selectedPromotion = document.getElementById('id_promotion').value;
            
            // Vérifier si une promotion est sélectionnée
            if (selectedPromotion === '') {
                alert('Veuillez sélectionner une promotion avant de copier le lien.');
                return; // Arrêter l'exécution de la fonction si aucune promotion n'est sélectionnée
            }
            
            var input = this.parentNode.querySelector('.link-input');
            var role = this.getAttribute('data-role');
            var link = "http://127.0.0.1:8000/register/" + role + "/" + selectedPromotion;
            input.value = link;
            input.style.display = 'block'; // Rendre l'élément input visible
            input.select();
            document.execCommand('copy');
            input.style.display = 'none'; // Rendre l'élément input invisible à nouveau
            alert('Lien copié dans le presse-papiers !');
        });
    });
</script>


@endsection

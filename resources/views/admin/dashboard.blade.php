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
                            <a href="{{route('memoire.allmemoire',['page'=>'yes'])}}" class="btn btn-primary">Publier des mémoires</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{Route('memoirepublier')}}" class="btn btn-primary">Gérer les mémoires publiées</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('memoire.allmemoire',['page'=>'no'])}}" class="btn btn-primary">Liste des mémoires</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('preinscription')}}" class="btn btn-primary">Pré inscription des etudiants </a>
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
    document.addEventListener('DOMContentLoaded', function() {
        var promotionSelect = document.getElementById('id_promotion');
        var copyButtons = document.querySelectorAll('.copy-button');

        function toggleCopyButtons() {
            var selectedPromotion = promotionSelect.value;
            copyButtons.forEach(function(button) {
                button.disabled = selectedPromotion === '';
            });
        }

        promotionSelect.addEventListener('change', toggleCopyButtons);
        toggleCopyButtons();

        copyButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var selectedPromotion = promotionSelect.value;

                if (selectedPromotion === '') {
                    alert('Veuillez sélectionner une promotion avant de copier le lien.');
                    return;
                }

                var input = this.parentNode.querySelector('.link-input');
                var role = this.getAttribute('data-role');

                var url = `/generate-link/${role}/${selectedPromotion}`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
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

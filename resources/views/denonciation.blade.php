@extends('layouts.base')
@section('titre')
<br>
    <div class="container">
        <div class="row justify-content-center">
            <div div class="col-md-8 col-lg-6" id="transparant" >
                <h1>Dénonciation</h1>
                <form action="{{ route('denonciation.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Email Address -->
                    <div>
                        <input type="email" name="email"  class="form-control" placeholder="Votre adreese email" value="{{ old('email') }}" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Nom -->
                    <div class="mt-2">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="votre noms complet" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Type de dénonciation -->
                    <div class="mt-2">
                        <select name="denonciation" id="denonciation" class="form-control" required onchange="togglePlagiatField()">
                            <option value="">Choisir ici type de plainte</option>
                            <option value="plagiat">Plagiat</option>
                            <option value="bugue">Bug de l'application</option>
                            <option value="autre">Autre</option>
                        </select>
                        <x-input-error :messages="$errors->get('denonciation')" class="mt-2" />
                    </div>
                    <!-- Titre du mémoire (champ conditionnel) -->
                    <div class="mt-2" id="plagiat-field" style="display: none;">
                        
                        <input type="text" name="titre_memoire" class="form-control"  value="{{ old('titre_memoire') }}" placeholder="titre du memoire incriminer" required>

                        <x-input-error :messages="$errors->get('titre_memoire')" class="mt-2" />
                    </div>
                    <!-- Description de la plainte -->
                    <div class="mt-2">
                        <textarea name="plainte" id="plainte" cols="5" rows="2" class="form-control" placeholder="Décrivez votre plainte ici...">{{ old('plainte') }}</textarea>
                        <x-input-error :messages="$errors->get('plainte')" class="mt-2" />
                    </div>
                    <!-- Preuves -->
                    <div class="mt-2">
                        <label for="preuve1 em-1" >Preuve 1 :</label>
                        <input type="file" name="preuve1" id="preuve1" class="form-control" required>
                        <x-input-error :messages="$errors->get('preuve1')" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <label for="preuve2">Preuve 2 :</label>
                        <input type="file" name="preuve2" id="preuve2" class="form-control">
                        <x-input-error :messages="$errors->get('preuve2')" class="mt-2" />
                    </div>
                    <div class="mt-2">
                        <label for="preuve3">Preuve 3 :</label>
                        <input type="file" name="preuve3" id="preuve3" class="form-control">
                        <x-input-error :messages="$errors->get('preuve3')" class="mt-2" />
                    </div>
                  <button class="btn btn-primary">Soummettre</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePlagiatField() {
            const denonciationSelect = document.getElementById('denonciation');
            const plagiatField = document.getElementById('plagiat-field');
            if (denonciationSelect.value === 'plagiat') {
                plagiatField.style.display = 'block';
            } else {
                plagiatField.style.display = 'none';
            }
        }
    </script>
@endsection

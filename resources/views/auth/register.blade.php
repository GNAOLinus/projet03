<x-guest-layout>
    <form id="registration-form" method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Display general errors -->
        @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- Name -->
        <div>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nom" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Adresse e-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Mot de passe" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Confirmer le mot de passe" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-text-input id="phone" class="block mt-1 w-full"
                            type="text"
                            name="phone" required autocomplete="phone" placeholder="Numéro de téléphone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        @if($role == 2)
        <div id="student">
            <!-- Contenu de la section student -->
            <input type="hidden" name="id_diplome" value="{{ $diplome }}">
            <!-- Site -->
            <div class="mt-4">
                <select name="id_site" id="site" class="form-control">
                    <option value="#">- Sélectionnez un site de ESM -</option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->site }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Filière -->
            <div class="mt-4">
                <select name="id_filiere" id="filiere" class="form-control">
                    <option value="">- Sélectionnez une filière -</option>
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->filiere }}</option>
                    @endforeach
                </select>
                @error('filiere')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        @endif

            <!-- Matricule -->
            <div class="mt-4">
                <x-text-input id="matricule" class="block mt-1 w-full" type="text" name="matricule" :value="old('matricule')" required autofocus autocomplete="matricule" placeholder="Votre Matricule" />
                <x-input-error :messages="$errors->get('matricule')" class="mt-2" />
            </div>
       

        <div class="from-group">
            <input type="hidden" name="id_promotion" value="{{ $promotion }}">
            <input type="hidden" name="id_role" value="{{ $role }}">
            <input type="hidden" name="encryptedData" value="{{ $encryptedData }}">
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <label for="terms">
                <input id="terms" type="checkbox" name="terms" required>
                <span style="color: yellow;">J'accepte les</span> <a href="{{ url('conditions_d_utilisation') }}" target="_blank">Conditions d'Utilisation</a>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>
        

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}" class="inline-flex px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Déjà enregistré ?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('S’inscrire') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('registration-form').addEventListener('submit', function(e) {
            var termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert("Vous devez accepter les conditions d'utilisation avant de soumettre le formulaire.");
            }
        });
    </script>
</x-guest-layout>

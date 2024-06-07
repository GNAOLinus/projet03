<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Téléchargement</title>
    @vite([
        'resources/css/app.css',
        'resources/css/style.css',
        'resources/js/app.js',
    ])
</head>
<body>
    <div class="container">
        <x-nav-bar></x-nav-bar>
<br>
<br>
<br>
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
<br><div class="alert alert-danger" role="alert">
    <x-info></x-info>     
  </div>
        <div class="row mt-5">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h3 class="text-center mb-4">Thème du mémoire : {{ $memoire->titre }}</h3>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Résumé du mémoire</h5>
                        <p class="card-text">{{ $memoire->resume }}</p>
                        <p class="card-text"><strong>Appréciation : </strong>{{ $memoire->appreciation }}</p>
                        <p class="card-text"><strong>Note : </strong>{{ $memoire->note }}</p>
                        <p class="card-text">
                            <strong>Réalisé par :</strong>
                            <form action="{{ route('profile') }}" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $memoire->binome->etudiant1->id }}">
                                <button class="btn btn-link p-0 m-0 align-baseline">{{ $memoire->binome->etudiant1->name }}</button>
                            </form>
                            et par son binôme
                            <form action="{{ route('profile') }}" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $memoire->binome->etudiant2->id }}">
                                <button class="btn btn-link p-0 m-0 align-baseline">{{ $memoire->binome->etudiant2->name }}</button>
                            </form> sous la supervissionde Mr{{ $memoire->encadreur}}
                        </p>

                        
                        <!-- Affichage des informations sur la soutenance -->
                    @if(isset($soutenance))
                    <p>Soutenu le  : {{ $soutenance->date_soutenance }} à {{ $soutenance->site->site }}</p>
                    <!-- Ajoutez d'autres informations sur la soutenance si nécessaire -->
                    @endif
                    </div>
                </div>

                <div class="mt-4">
                    <form id="payment-form" action="{{ route('memoire.download', $memoire->id) }}" method="get">
                        @csrf
                        <input type="hidden" name="idmemoire" value="{{ $memoire->id }}">
                        <script
                            src="https://checkout.fedapay.com/js/checkout.js"
                            data-public-key="pk_live_LJ5uKvznLx7VqDqETT-jmut4"
                            data-button-text="Payer 500 frans CFA"
                            data-button-class="btn btn-primary"
                            data-transaction-amount="500"
                            data-transaction-description="Description de la transaction"
                            data-currency-iso="XOF"
                            data-widget-description="ESM-Bénin"
                            data-widget-image="https://live-checkout.fedapay.com/img/marketplace.svg"
                            data-widget-title="Afrimarket"
                            data-on-error="handleFedapayError"
                            data-on-success="handleFedapaySuccess"
                            data-submit_form_on_failed='false'>
                            
                        </script>
                    </form>
                </div>

                <!-- Afficher les messages d'erreur -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    
    <script>
       function handleFedapayError(event, error) {
    console.error('Fedapay Error:', error);
    // Empêchez la soumission du formulaire en cas d'échec de la transaction Fedapay
    event.preventDefault();
}


        function handleFedapaySuccess(transaction) {
            console.log('Fedapay Success:', transaction);
            // Soumettez le formulaire en cas de succès de la transaction Fedapay
            document.getElementById('payment-form').submit();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titel')</title>
    @vite([
        'resources/css/style.css',
        'resources/js/app.js',
    ])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .image-banner2 {
            background-size: cover; /* Pour couvrir toute la surface de l'élément parent */
            background-position: center; /* Pour centrer l'image */
            min-height: 300px; /* Hauteur minimale de la bannière */
        }
    </style>
</head>
<body>
    <x-nav-bar> </x-nav-bar>
    <br><br>
    <header class="image-banner2" style="background-image: url('{{ asset('image/banière.jpg') }}');">
        <div class="container-fluid h-100"> <!-- Utilisation de container-fluid pour une largeur maximale -->
            <div class="row h-100 align-items-center"> <!-- Utilisation de row et align-items-center pour centrer verticalement -->
                <div class="col-md-12 text-center text-white"> <!-- Utilisation de col-md-12 pour une largeur maximale sur les petits écrans -->
                    <h1>@yield('titre')</h1>
                    <h3>@yield('paragraphe')</h3>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-5"> <!-- Ajout de marges pour un espacement adéquat -->
        @yield('content')
    </div>
</body>
</html>

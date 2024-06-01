<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titel')</title>
    @vite([
      'resources/css/app.css',
      'resources/css/style.css',
      'resources/js/app.js',
  ])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <x-nav-bar> </x-nav-bar>
    <header class="image-banner2" style="background-image: url('{{ asset('image/banière.jpg') }}');">
        <div class="container h-100 " >
          <div class="d-flex h-100 text-center align-items-center">
            <div class="w-100 text-white">
             
              <h1> @yield('titre')</h1>
              <h3>@yield('paragraphe')</h3>
              
            </div>
          </div>
        </div>
      </header>
    @yield('content')
   
</body>
</html>
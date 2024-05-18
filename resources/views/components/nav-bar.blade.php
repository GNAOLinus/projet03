<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img class="navbar-logo" src="{{ asset('image/logo.png') }}" alt="" srcset="" style="max-height: 80px;">
  </a>
    <a class="navbar-brand " href="#">Banque Mémoire <br> ESM-Bénin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
     
    </button>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link "  href="{{('/')}}">Acceuil</a>
        </li>
        <li class="nav-item"> 
          <a class="nav-link "  href="{{route('recherche.filtre')}}">Filtre</a>
        </li>
        <li class="nav-item"> 
          <a class="nav-link " href="{{route('login')}}">S'authentifier</a>
        </li>
      </ul>
      <form class="d-flex" action="{{ route('recherche') }}" method="GET">
        <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search" value="{{ request('query') }}">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
  </div>
</nav>

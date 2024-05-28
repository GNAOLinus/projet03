@extends('dashboard')

@section('content')
<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Télécharger le fichier de préinscription</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('preinscription.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="fichierpreinscription">Fichier de préinscription</label>
                            <input type="file" name="fichier" class="form-control-file">
                        </div>
                        <button type="submit" class="btn btn-primary">Télécharger</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

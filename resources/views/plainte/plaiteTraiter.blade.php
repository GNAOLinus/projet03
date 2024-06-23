@extends('dashboard')
@section('content')
<br>
<div class="container">
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

    <div class="row justify-content-center">
        <div class="">
            <h2 class="mb-4">Liste des dénonciations traiter</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Nom</th>
                        <th>Type de Dénonciation</th>
                        <th>Plainte</th>
                        <th>Titre du Mémoire</th>
                        <th>Date de Création</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($denonciations as $denonciation)
                    @if ($denonciation->statut !== null)
                        <tr>
                            <td>{{ $denonciation->id }}</td>
                            <td><a href="mailto:{{ $denonciation->email }}?subject=Information%20sur%20la%20Dénonciation&body=Bonjour">
                                <i class="fas fa-envelope"></i> {{ $denonciation->email }}
                            </a></td>
                            <td>{{ $denonciation->name }}</td>
                            <td>{{ $denonciation->denonciation }}</td>
                            <td>{{ $denonciation->plainte }}</td>
                            <td>{{ $denonciation->titre_memoire }}</td>
                            <td>{{ $denonciation->created_at }}</td>
                            <td>{{ $denonciation->statut }}
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

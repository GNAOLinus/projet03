@extends('dashboard')

@section('content')
<div class="container">
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Détails de la Dénonciation</h2>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $denonciation->id }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $denonciation->email }}</td>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <td>{{ $denonciation->name }}</td>
                    </tr>
                    <tr>
                        <th>Type de Dénonciation</th>
                        <td>{{ $denonciation->denonciation }}</td>
                    </tr>
                    <tr>
                        <th>Plainte</th>
                        <td>{{ $denonciation->plainte }}</td>
                    </tr>
                    <tr>
                        <th>Titre du Mémoire</th>
                        <td>{{ $denonciation->titre_memoire }}</td>
                    </tr>
                    <tr>
                        <th>Date de Création</th>
                        <td>{{ $denonciation->created_at }}</td>
                    </tr>
                    @if($denonciation->preuve1 || $denonciation->preuve2 || $denonciation->preuve3)
                        <tr>
                            <th>Preuves</th>
                            <td>
                                @if($denonciation->preuve1)
                                    <a href="{{ asset('storage/' . $denonciation->preuve1) }}" target="_blank">Preuve 1</a><br>
                                @endif
                                @if($denonciation->preuve2)
                                    <a href="{{ asset('storage/' . $denonciation->preuve2) }}" target="_blank">Preuve 2</a><br>
                                @endif
                                @if($denonciation->preuve3)
                                    <a href="{{ asset('storage/' . $denonciation->preuve3) }}" target="_blank">Preuve 3</a><br>
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <a href="{{ route('denonciation.index') }}" class="btn btn-secondary">Retour à la liste</a>
            
            {{-- Form for updating the status --}}
            <form action="{{ route('denonciation.update', $denonciation->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="statut" value="traitee">
                <button type="submit" class="btn btn-primary">Traiter</button>
            </form>
        </div>
    </div>
</div>
@endsection

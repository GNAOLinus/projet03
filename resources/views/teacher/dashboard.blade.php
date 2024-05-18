@extends('dashboard')
@section('content')
<div class="container">
    <h1>Appréciation des mémoires</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Action</th>
                <th>Appréciation</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach($memoires as $memoire)
            <tr>
                <td>{{ $memoire->titre }}</td>
                @if($memoire->binome)
                <td>{{ $memoire->binome->etudiant1->name }} et {{ $memoire->binome->etudiant2->name }}</td>
                @else
                <td>Aucun binôme associé</td>
                @endif
                <td><a href="{{ asset('memoires/' . $memoire->fichier) }}">voir</a></td>
                <td>
                    @if($memoire->appreciation !== null)
                        <span>Appréciation : {{ $memoire->appreciation }}</span><br>
                        <span>Note : {{ $memoire->note }}</span>
                    @else
                        <form action="{{ route('memoires.updateAppreciation', ['id' => $memoire->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <select name="appreciation">
                                <option value="">Choisir une appréciation</option>
                                <option value="excellent">Excellent</option>
                                <option value="tres_bien">Très bien</option>
                                <option value="bien">Bien</option>
                                <option value="moyen">Moyen</option>
                                <option value="insuffisant">Insuffisant</option>
                            </select>
                            <label for="note">Note :</label>
                            <input type="number" name="note" id="note" min="0" max="20" required>
                            <button type="submit" class="btn btn-primary">Enregistrer l'appréciation</button>
                        </form>
                    @endif
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

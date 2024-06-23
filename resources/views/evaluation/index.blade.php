@extends('dashboard')

@section('content')
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
            <div class="col-md-10">
                <h1 class="mb-4">Liste des Évaluations</h1>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Données</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluations as $evaluation)
                        <tr>
                            <th scope="row">{{ $evaluation->id }}</th>
                            <td>
                                <p><strong>Mémoire analysé :</strong> ID {{ $evaluation->id_memoire }}</p>
                                <form action="{{route('evaluation.doc')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $evaluation->id_memoire }}">
                                    <button class="btn btn-primary">Télécharger le doc</button>
                                </form>
                                <ul>
                                    @foreach(json_decode($evaluation->data)->topSimilarities as $index => $similarity)
                                        <li>
                                            <strong>Mémoire ID :</strong> {{ json_decode($evaluation->data)->top_memoire_ids[$index] }}
                                            <form action="{{route('evaluation.doc')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{json_decode($evaluation->data)->top_memoire_ids[$index]}}">
                                                <button class="btn btn-primary">Télécharger le doc</button>
                                            </form>
                                            <br>
                                            <strong>Similarité :</strong> {{ $similarity }}%
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

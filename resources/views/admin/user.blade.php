@extends('dashboard')
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-9">
            <h2 style="text-align: center;">Système de gestion des utilisateurs</h2>
            <table class="table table-bordered">
                <tr>
                    <th>NOM </th>
                    <th> role</th>
                    <th>Action</th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->id_role }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
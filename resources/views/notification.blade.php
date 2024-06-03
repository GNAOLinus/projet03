@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1>Notifications</h1>
                <!-- Afficher les notifications non lues -->
                <ul>
                    @foreach ($notificationsNonLu as $notification)
                        <li>
                            {{ $notification->data['message'] }} - 
                            {{ $notification->created_at->format('Y-m-d H:i:s') }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

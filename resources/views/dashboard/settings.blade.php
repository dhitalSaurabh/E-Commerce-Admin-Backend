@extends('./layouts.userdash')

@section('content')
@if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <h2>My Settings</h2>
@endsection
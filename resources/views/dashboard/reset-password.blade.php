@extends('./layouts.userdash')

@section('content')
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif
    Password reset
    <x-user-forms.reset-user-password />
    <script src="{{ asset('js/user/reset-password-api.js')}}"></script>

@endsection
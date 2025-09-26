@extends('./layouts.userdash')

@section('content')
@if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif
 <div id="loadOrdersView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
    <h2>My Orders</h2>

 <script src="{{ asset('js/user-api/order.js')}}"></script>
@endsection
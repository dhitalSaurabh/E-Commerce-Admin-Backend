@extends('./layouts.userdash')
<style>


</style>
@section('content')
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <h2>My Profile</h2>
    <div class="dialog-overlay" id="userAddressDialog">
        <div class="dialog-box">
            <button class="close-dialog" onclick="closeAddressDialog()">×</button>
            <h2>Please Add user Address to continue</h2>
            <x-user-forms.useradress />
        </div>
    </div>
    <div id="userAddressGrid" class="p-4"></div>
    <script>
        function EditUserInfo() {

            document.getElementById("userAddressDialog").classList.remove("hidden");
            document.getElementById("userAddressDialog").classList.add("flex");


        }
        function closeAddressDialog() {
            document.getElementById("userAddressDialog").classList.add("hidden");

        }
    </script>
    <script src="{{ asset('js/user-api/user-address-api.js')}}"></script>
@endsection
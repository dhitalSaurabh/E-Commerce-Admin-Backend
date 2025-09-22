@extends('./layouts.userdash')

@section('content')
    <style>
        /* Dialog box styles */
        .dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .dialog-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .dialog-box h2 {
            margin-top: 0;
        }

        .close-dialog {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-add {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-add:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-actions {
            text-align: right;
        }
    </style>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif
    {{-- <div class="dialog-overlay" id="userAddressDialog">
        <div class="dialog-box">
            <button class="close-dialog" onclick="closeDialog()">×</button>
            <h2>Please Add user Address to continue</h2>
            <x-user-forms.useradress />
        </div>
    </div>
    <div class="dialog-overlay" id="orderDialog">
        <div class="dialog-box">
            <button class="close-dialog" onclick="closeDialog()">×</button>
            <h2>Please Fill this form to confirm order.</h2>
            <x-user-forms.order />
        </div>
    </div> --}}


    <!-- Dialog Container -->
    <div id="dialogContainer" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
            <span class="absolute top-2 right-3 text-gray-600 cursor-pointer" onclick="closeDialog()">✕</span>

            <!-- Dialog A -->
            <div id="dialogA" class="hidden">
                <h2 class="text-xl font-bold mb-4">Confirm Your Order</h2>
                <p>You already have an address. Proceed with your order?</p>
                <x-user-forms.order />
            </div>

            <!-- Dialog B -->
            <div id="dialogB" class="hidden">
                <h2 class="text-xl font-bold mb-4">Add Your Address</h2>
                <p>You need to add an address before placing the order.</p>
                <x-user-forms.useradress />
            </div>

        </div>
    </div>
     <div class="dialog-overlay" id="addCartDialog">
        <div class="dialog-box">
            <button class="close-dialog" onclick="closeDialog()">×</button>
            <h2>Add to cart</h2>
            <x-cart-form.add-cart />
        </div>
    </div>
    <!--  grid -->
    <div id="varientsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- JavaScript will populate  here -->
    </div>
    <script src="{{ asset('js/user-api/user-address-api.js')}}"></script>
    <script src="{{ asset('js/user-api/variants.js')}}"></script>
    <script src="{{ asset('js/user-api/order.js')}}"></script>
    <script src="{{ asset('js/user-api/cart-user.js')}}"></script>


@endsection
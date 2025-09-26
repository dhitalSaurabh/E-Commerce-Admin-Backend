@extends('./layouts.userdash')
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
@section('content')
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <h2>My Profile</h2>
    <div class="dialog-overlay hidden" id="userAddressDialog">
        <div class="dialog-box">
            <button class="close-dialog" onclick="closeAddressDialog()">×</button>
            <h2>Update User Address</h2>
            <x-user-forms.edit-user-address />
        </div>
    </div>
    <div id="userAddressGrid" class="p-4"></div>
    <script>
        function EditUserInfo(id, full_name, phone, city, state) {
            const dialog = document.getElementById("userAddressDialog");
            dialog.classList.remove("hidden");
            dialog.classList.add("flex");
            // data
            document.getElementById("editId").value = id;
            document.getElementById("editfull_name").value = full_name;
            document.getElementById("editphone").value = phone;
            document.getElementById("editcity").value = city;
            document.getElementById("editstate").value = state;

        }

        function closeAddressDialog() {
            const dialog = document.getElementById("userAddressDialog");
            dialog.classList.remove("flex");
            dialog.classList.add("hidden");
        }
        document.getElementById("editUserAddressForm").addEventListener("submit", async (e) => {
            e.preventDefault();

            const id = document.getElementById("editId").value;
            const updatedData = {
                full_name: document.getElementById("editfull_name").value,
                phone: document.getElementById("editphone").value,
                city: document.getElementById("editcity").value,
                state: document.getElementById("editstate").value,
                // price: document.getElementById("editPrice").value,
            };

            // const imageFile = document.getElementById("editImage").files[0];
            // if (imageFile) updatedData.image = imageFile;

            await updateUserAddress(id, updatedData);
        });

    </script>
    <script src="{{ asset('js/user-api/user-address-api.js')}}"></script>
@endsection
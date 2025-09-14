@extends('./layouts.app')

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

    <div class="container mt-4">
        <!-- Top Bar with Title and Add Button -->
        <div class="top-bar">
            <h1>All Clothes</h1>
            <button class="btn-add" onclick="openDialog()">+ Add Clothes</button>
        </div>

        {{-- Clothes table or grid would go here --}}
    </div>
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif
    <!-- Dialog Overlay -->
    <div class="dialog-overlay" id="addClothesDialog">
        <div class="dialog-box">
            <button class="close-dialog" onclick="closeDialog()">×</button>
            <h2>Add Clothes</h2>
            <x-cloths_form />
        </div>
    </div>
    <x-update_cloth_form />
    <!-- Clothes grid -->
    <div id="clothesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- JavaScript will populate clothes here -->
    </div>
    <script src="{{ asset('js/clothes-form.js')}}"></script>
    <script src="{{ asset('js/load-clothes.js')}}"></script>

    <script>
        function openDialog() {
            document.getElementById('addClothesDialog').style.display = 'flex';
        }

        function closeDialog() {
            document.getElementById('addClothesDialog').style.display = 'none';
        }
    </script>


    <script>
        function openEditDialog(id, name, slug, description, price) {
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editSlug").value = slug;
            document.getElementById("editDescription").value = description;
            document.getElementById("editPrice").value = price;
            document.getElementById("editDialog").classList.remove("hidden");
            document.getElementById("editDialog").classList.add("flex");
        }

        function closeEditDialog() {
            document.getElementById("editDialog").classList.add("hidden");
        }
        document.getElementById("editForm").addEventListener("submit", async (e) => {
            e.preventDefault();

            const id = document.getElementById("editId").value;
            const updatedData = {
                name: document.getElementById("editName").value,
                slug: document.getElementById("editSlug").value,
                description: document.getElementById("editDescription").value,
                price: document.getElementById("editPrice").value,
            };

            const imageFile = document.getElementById("editImage").files[0];
            if (imageFile) updatedData.image = imageFile;

            await updateClothingItem(id, updatedData);
        });

    </script>
@endsection
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
            <h1>All Categories</h1>
            <button class="btn-add" onclick="openDialog()">+ Add Category</button>
        </div>

        {{-- Clothes table or grid would go here --}}
    </div>
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif
    <!-- Dialog Overlay -->
    <div class="dialog-overlay" id="addCategoriesDialog">
        <div class="dialog-box">
            <button class="close-dialog" onclick="closeDialog()">×</button>
            <h2>Add Category</h2>
            <form id="categoriesForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-1">Category Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="text-right">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition">
                        Submit
                    </button>
                </div>

                <div id="errorMessage" class="text-red-500 mt-2"></div>
            </form>

        </div>
    </div>
    {{-- <x-update_cloth_form /> --}}
    <div id="editDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96 relative">
        <button onclick="closeEditDialog()" class="absolute top-2 right-3 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Category</h2>
        <form id="editForm" class="space-y-4">
            <input type="hidden" id="editId">
            <div>
                <label class="block">Name</label>
                <input type="text" id="editName" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</div>
    <!-- Clothes grid -->
    <div id="categoriesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- JavaScript will populate clothes here -->
    </div>
    <script src="{{ asset('js/categories-api.js')}}"></script>
    {{--
    <script src="{{ asset('js/load-clothes.js')}}"></script> --}}

    <script>
        function openDialog() {
            document.getElementById('addCategoriesDialog').style.display = 'flex';
        }

        function closeDialog() {
            document.getElementById('addCategoriesDialog').style.display = 'none';
        }
    </script>


    <script>
        function openEditDialog(id, name) {
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
            // document.getElementById("editParentId").value = parent_id;
            // document.getElementById("editSlug").value = slug;
            // document.getElementById("editDescription").value = description;
            // document.getElementById("editPrice").value = price;
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
            };
            await updateCategoryItem(id, updatedData);
        });

    </script>
@endsection
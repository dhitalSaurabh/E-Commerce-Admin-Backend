<div id="editDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96 relative">
        <button onclick="closeEditDialog()" class="absolute top-2 right-3 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Clothing</h2>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" id="editId">
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Clothing Name</label>
                <input type="text" id="editName" name="name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
                <input type="text" id="editDescription" name="description" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="price" class="block text-gray-700 font-medium mb-1">Price (Rs)</label>
                <input type="number" step="1" id="editPrice" name="price" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="brand" class="block text-gray-700 font-medium mb-1">Brand</label>
                <input type="text" id="editBrand" name="brand" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="sku" class="block text-gray-700 font-medium mb-1">SKU</label>
                <input type="text" id="editSku" name="sku" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="image" class="block text-gray-700 font-medium mb-1">Image</label>
                <input type="file" id="editImage" name="image" accept="image/*"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            {{-- <div>
                <label for="category_id" class="block text-gray-700 font-medium mb-1">Category</label>
                <input type="text" id="editCategory" name="category_id" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div> --}}
            <select id="EditcategoryId" name="category_id" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Select a Category</option>
            </select>
            <div class="text-right">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition">
                    Update
                </button>
            </div>

            <div id="errorMessage" class="text-red-500 mt-2"></div>
        </form>
    </div>
</div>
    {{-- <script src="{{ asset('js/dropdown-categories.js')}}"></script> --}}
<script>
    
</script>
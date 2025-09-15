<form id="productsForm" method="POST" enctype="multipart/form-data" class="space-y-4">
    <div>
        <label for="name" class="block text-gray-700 font-medium mb-1">Product Name</label>
        <input type="text" id="name" name="name" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
        <input type="text" id="description" name="description" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="price" class="block text-gray-700 font-medium mb-1">Price</label>
        <input type="number" step="1" id="price" name="price" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="brand" class="block text-gray-700 font-medium mb-1">Brand</label>
        <input type="text" id="brand" name="brand" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label for="sku" class="block text-gray-700 font-medium mb-1">SKU</label>
        <input type="text" id="sku" name="sku" required placeholder="NIKE-AMAX-001"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label for="image" class="block text-gray-700 font-medium mb-1">Image</label>
        <input type="file" id="image" name="image" accept="image/*" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    {{-- <div>
        <label for="category_id" class="block text-gray-700 font-medium mb-1">Category</label>
        <input type="text" id="category_id" name="category_id" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div> --}}
    <select id="category_id" name="category_id" required
    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    <option value="">Select a Category</option>
</select>
    <div class="text-right">
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition">
            Submit
        </button>
    </div>

    <div id="errorMessage" class="text-red-500 mt-2"></div>
</form>
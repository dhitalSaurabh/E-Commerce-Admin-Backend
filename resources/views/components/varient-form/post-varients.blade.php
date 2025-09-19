<form id="varientsForm" method="POST" enctype="multipart/form-data" class="space-y-4">
    {{-- <div>
        <label for="productId" class="block text-gray-700 font-medium mb-1">Product Id</label>
        <input type="number" id="product_id" name="product_id" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div> --}}
    <select id="product_id" name="product_id" required
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Select a Product</option>
    </select>
    <div>
        <label for="size" class="block text-gray-700 font-medium mb-1">Size</label>
        <input type="text" id="size" name="size" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="color" class="block text-gray-700 font-medium mb-1">Color</label>
        <input type="text" step="1" id="color" name="color" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="material" class="block text-gray-700 font-medium mb-1">Material</label>
        <input type="text" id="material" name="material" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label for="price" class="block text-gray-700 font-medium mb-1">Price</label>
        <input type="number" id="price" name="price" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
        <label for="sku" class="block text-gray-700 font-medium mb-1">SKU</label>
        <input type="text" id="sku" name="sku" required placeholder="NIKE-AMAX-001"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    {{-- <div>
        <label for="category_id" class="block text-gray-700 font-medium mb-1">Category</label>
        <input type="text" id="category_id" name="category_id" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div> --}}
    <div>
        <label for="image" class="block text-gray-700 font-medium mb-1">Image</label>
        <input type="file" id="image" name="image" accept="image/*" required
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
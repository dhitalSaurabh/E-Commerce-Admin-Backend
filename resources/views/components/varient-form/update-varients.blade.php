<div id="editDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96 relative">
        <button onclick="closeEditDialog()" class="absolute top-2 right-3 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Clothing</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" id="editId">
            {{-- <div>
                <label for="productId" class="block text-gray-700 font-medium mb-1">Product Id</label>
                <input type="number" id="editProductId" name="product_id" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div> --}}
            <select id="editProductId" name="editProductId" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Select a Product</option>
            </select>
            <div>
                <label for="size" class="block text-gray-700 font-medium mb-1">Size</label>
                <input type="text" id="editSize" name="size" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="color" class="block text-gray-700 font-medium mb-1">Color</label>
                <input type="text" step="1" id="editColor" name="color" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="material" class="block text-gray-700 font-medium mb-1">Material</label>
                <input type="text" id="editMaterial" name="material" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="additional_price" class="block text-gray-700 font-medium mb-1">Additional_price</label>
                <input type="number" id="editAdditionalPrice" name="additional_price" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="sku" class="block text-gray-700 font-medium mb-1">SKU</label>
                <input type="text" id="editSku" name="sku" required placeholder="NIKE-AMAX-001"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            {{-- <select id="category_id" name="category_id" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Select a Category</option>
            </select> --}}
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
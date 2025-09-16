<form id="InventoryForm" method="POST" enctype="multipart/form-data" class="space-y-4">
    <select id="variant_id" name="variant_id" required
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Select a Varient</option>
        {{-- <option value="1">1</option> --}}
    </select>
    {{-- <div>
        <label for="variant_id" class="block text-gray-700 font-medium mb-1">Varient Id</label>
        <input type="number" step="1" id="variant_id" name="variant_id" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div> --}}
    <div>
        <label for="stock_quantity" class="block text-gray-700 font-medium mb-1">Stock Quantity</label>
        <input type="number" step="1" id="stock_quantity" name="stock_quantity" required
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
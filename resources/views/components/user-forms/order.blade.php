<form id="orderForm" method="POST" enctype="multipart/form-data" class="space-y-4">
    <div>
        <label for="variant_id" class="block text-gray-700 font-medium mb-1">Variant</label>
        <input type="number" id="variant_id" name="variant_id" required readonly
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="quantity" class="block text-gray-700 font-medium mb-1">Quantity</label>
        <input type="number" id="quantity" name="quantity" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="price" class="block text-gray-700 font-medium mb-1">Price</label>
        <input type="number" step="1" id="price" name="price" required readonly
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="total_amount" class="block text-gray-700 font-medium mb-1">Total Amount</label>
        <input type="number" id="total_amount" name="total_amount" required readonly
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    {{-- <select id="category_id" name="category_id" required
    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    <option value="">Select a Category</option>
</select> --}}
    <div class="text-right">
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition">
            Order Now
        </button>
    </div>

    <div id="errorMessage" class="text-red-500 mt-2"></div>
</form>
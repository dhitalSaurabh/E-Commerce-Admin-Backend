<form id="AddCartForm" method="POST" enctype="multipart/form-data" class="space-y-4">
    <div>
        <label for="quantity" class="block text-gray-700 font-medium mb-1">Quantity</label>
        <input type="number" step="1" id="quantity" name="quantity" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div class="text-right">
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition">
            Add to your cart
        </button>
    </div>
    <div id="errorMessage" class="text-red-500 mt-2"></div>
</form>
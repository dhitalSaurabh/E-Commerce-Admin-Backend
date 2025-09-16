<div id="editDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96 relative">
        <button onclick="closeEditDialog()" class="absolute top-2 right-3 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Stock</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" id="editId">
    <select id="editVarientId" name="editVarientId" required
        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Select a Varient</option>
        <option value="1">1</option>
    </select>
    <div>
        <label for="editStockQuantity" class="block text-gray-700 font-medium mb-1">Stock Quantity</label>
        <input type="number" step="1" id="editStockQuantity" name="stock_quantity" required
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
    {{-- <script src="{{ asset('js/dropdown-categories.js')}}"></script> --}}
<script>
    
</script>
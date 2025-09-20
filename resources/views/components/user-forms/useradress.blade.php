<form id="userAddressForm" method="POST" enctype="multipart/form-data" class="space-y-4">
    <div>
        <label for="full_name" class="block text-gray-700 font-medium mb-1">Full Name</label>
        <input type="text" id="full_name" name="full_name" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="phone" class="block text-gray-700 font-medium mb-1">Phone No.</label>
        <input type="number" id="phone" name="phone" required maxlength="10"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="city" class="block text-gray-700 font-medium mb-1">Delivery Address</label>
        <input type="text" id="city" name="city" required
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>

    <div>
        <label for="state" class="block text-gray-700 font-medium mb-1">State</label>
        <input type="text" id="state" name="state" required
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
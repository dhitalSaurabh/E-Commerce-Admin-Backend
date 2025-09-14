<div id="editDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-96 relative">
        <button onclick="closeEditDialog()" class="absolute top-2 right-3 text-2xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Clothing</h2>
        <form id="editForm" class="space-y-4">
            <input type="hidden" id="editId">
            <div>
                <label class="block">Name</label>
                <input type="text" id="editName" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Slug</label>
                <input type="text" id="editSlug" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Description</label>
                <input type="text" id="editDescription" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Price</label>
                <input type="number" id="editPrice" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block">Image (optional)</label>
                <input type="file" id="editImage" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</div>
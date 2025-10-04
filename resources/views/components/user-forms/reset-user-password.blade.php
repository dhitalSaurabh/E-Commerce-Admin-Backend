<form class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg space-y-6"
  id = "resetPasswordForm">
  <h2 class="text-2xl font-semibold text-gray-800 text-center">Reset Password</h2>

  <!-- Old Password -->
  <div>
    <label for="old_password" class="block text-sm font-medium text-gray-700 mb-1">Old Password</label>
    <input type="password" id="old_password" name="old_password" required
      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Enter old password">
  </div>

  <!-- New Password -->
  <div>
    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
    <input type="password" id="new_password" name="new_password" required minlength="6"
      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Enter new password">
  </div>

  <!-- Confirm New Password -->
  <div>
    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required
      class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
      placeholder="Confirm new password">
  </div>

  <!-- Submit Button -->
  <div>
    <button type="submit"
      class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
      Update Password
    </button>
  </div>
  <div id="errorMessage" class="text-red-500 mt-2"></div>
</form>
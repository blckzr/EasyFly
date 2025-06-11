// Load selected employee data into edit modal
    $('#editEmployeeModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget);
      const id = button.data('id');
      // TODO: Use AJAX to fetch data from server and fill inputs
      // Example:
      // $('#edit-id').val(id);
      // $('#edit-admin-id').val(...);
      // $('#edit-first-name').val(...);
    });

    // Pass selected ID to delete modal
    $('#deleteEmployeeModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget);
      const id = button.data('id');
      $('#delete-id').val(id);
    });

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('#addEmployeeModal form');
  const password = form.querySelector('input[name="password"]');
  const confirmPassword = form.querySelector('input[name="confirm_password"]');

  form.addEventListener('submit', function (e) {
    if (password.value !== confirmPassword.value) {
      e.preventDefault(); // Stop form submission
      alert('Passwords do not match!');
      confirmPassword.focus();
    }
  });
});

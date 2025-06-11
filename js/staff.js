
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

  // Handle delete modal logic
  $('#deleteEmployeeModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const id = button.data('id');

    if (id) {
      // Single delete via trash button
      $('#deleteEmployeeModal form input[name="ids[]"]').remove(); // Clear any previous inputs
      $('#deleteEmployeeModal form').append(
        $('<input>').attr({
          type: 'hidden',
          name: 'ids[]',
          value: id
        })
      );
    } else {
      // Bulk delete
      const selectedIds = $('.rowCheckbox:checked').map(function () {
        return this.value;
      }).get();

      if (selectedIds.length === 0) {
        alert("Please select at least one employee to delete.");
        $('#deleteEmployeeModal').modal('hide');
        return;
      }

      $('#deleteEmployeeModal form input[name="ids[]"]').remove(); // Clear old
      selectedIds.forEach(function (val) {
        $('#deleteEmployeeModal form').append(
          $('<input>').attr({
            type: 'hidden',
            name: 'ids[]',
            value: val
          })
        );
      });
    }
  });

  // Handle add employee password match validation
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

    // Select All checkbox logic
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.rowCheckbox');

    selectAll.addEventListener('change', function () {
      checkboxes.forEach(cb => cb.checked = this.checked);
    });

    checkboxes.forEach(cb => {
      cb.addEventListener('change', function () {
        if (!this.checked) {
          selectAll.checked = false;
        } else if ([...checkboxes].every(box => box.checked)) {
          selectAll.checked = true;
        }
      });
    });
  });

// Edit modal
$(document).on('click', '.edit', function () {
  const row = $(this).closest('tr');

  const id = $(this).data('id');
  const adminId = row.find('td:nth-child(2)').text().trim();
  const firstName = row.find('td:nth-child(3)').text().trim();
  const lastName = row.find('td:nth-child(4)').text().trim();
  const username = row.find('td:nth-child(5)').text().trim();

  $('#edit-id').val(id);
  $('#edit-admin-id').val(adminId);
  $('#edit-first-name').val(firstName);
  $('#edit-last-name').val(lastName);
  $('#edit-username').val(username);

  // Clear password fields
  $('#edit-old-password').val('');
  $('#edit-new-password').val('');
  $('#edit-confirm-password').val('');
});

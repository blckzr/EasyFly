const flights = [
  {
    flightNumber: "MNLJPN-1120",
    date: "5/21/2025",
    time: "11:00:00 AM",
    source: "Manila, PH",
    destination: "Tokyo, Japan",
    status: "Pending",
  },
]

function filterFlights() {
  const dateFilter = document.querySelector('select[aria-label="Date"]').value
  const timeFilter = document.querySelector('select[aria-label="Time"]').value
  const sourceFilter = document.querySelector('select[aria-label="Source"]').value
  const destinationFilter = document.querySelector('select[aria-label="Destination"]').value

  console.log("Filtering flights...", { dateFilter, timeFilter, sourceFilter, destinationFilter })
}

function editFlight(element) {
  const row = element.closest("tr")
  const flightNumber = row.cells[0].textContent
  const date = row.cells[1].textContent
  const time = row.cells[2].textContent
  const source = row.cells[3].textContent
  const destination = row.cells[4].textContent
  const status = row.cells[5].textContent

  alert(
    `Edit Flight: ${flightNumber}\nDate: ${date}\nTime: ${time}\nFrom: ${source}\nTo: ${destination}\nStatus: ${status}`,
  )

}

function deleteFlight(element) {
  const row = element.closest("tr")
  const flightNumber = row.cells[0].textContent

  if (confirm(`Are you sure you want to delete flight ${flightNumber}?`)) {
    row.remove()
    alert(`Flight ${flightNumber} has been deleted.`)
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const filterSelects = document.querySelectorAll(".filter-section select")
  filterSelects.forEach((select) => {
    select.addEventListener("change", filterFlights)
  })
})

// Edit Modal
$(document).on('click', '.editBtn', function () {
    const button = $(this);

    // Get data attributes
    const flightNumber = button.data('flightnumber');
    const from = button.data('from');
    const to = button.data('to');
    const time = button.data('time');
    const date = button.data('date');

    // Set values in modal
    $('#editFlight input[name="originalFlightNumber"]').val(flightNumber);
    $('#editFlight input[name="flightNumber"]').val(flightNumber);
    $('#editFlight input[name="from"]').val(from);
    $('#editFlight input[name="to"]').val(to);
    $('#editFlight input[name="time"]').val(time);
    $('#editFlight input[name="date"]').val(date);
});

// Filter
document.getElementById('filterBtn').addEventListener('click', function () {
    const limit = document.getElementById('limitInput').value;
    const date = document.getElementById('dateFilter').value;
    const time = document.getElementById('timeFilter').value;

    // Build the query string
    const query = new URLSearchParams({
        limit: limit,
        date_filter: date,
        time_filter: time
    });

    // Reload the page with filters as query parameters
    window.location.href = window.location.pathname + "?" + query.toString();
});

window.onload = () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('date_filter')) {
            document.getElementById('dateFilter').value = urlParams.get('date_filter');
        }
        if (urlParams.get('time_filter')) {
            document.getElementById('timeFilter').value = urlParams.get('time_filter');
        }
        if (urlParams.get('limit')) {
            document.getElementById('limitInput').value = urlParams.get('limit');
        }
    };
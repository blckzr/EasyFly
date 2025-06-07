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

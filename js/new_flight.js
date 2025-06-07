document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("newFlightForm")

  form.addEventListener("submit", (e) => {
    e.preventDefault()

    const flightData = {
      flightNumber: document.getElementById("flightNumber").value,
      from: document.getElementById("from").value,
      time: document.getElementById("time").value,
      to: document.getElementById("to").value,
      date: document.getElementById("date").value,
    }

    console.log("New flight data:", flightData)
    alert("Flight created successfully!")

    window.location.href = "flight_logs.html"
  })
})

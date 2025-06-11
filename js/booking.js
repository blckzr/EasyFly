// Global variables
let currentStep = 1
let passengerCount = 0
let selectedFlight = null
let bookingIdCounter = 1
let currentBgIndex = 0

const bookingData = {
  itinerary: "ROUND",
  class: "ECONOMY",
  departureFrom: "",
  arrivalTo: "",
  departureDate: "",
  returnDate: "",
  selectedFlight: null,
  bookerDetails: {},
  passengers: [],
}

function initBackgroundSlideshow() {
  setInterval(() => {
    const slides = document.querySelectorAll(".bg-slide")
    slides[currentBgIndex].classList.remove("active")
    currentBgIndex = (currentBgIndex + 1) % slides.length
    slides[currentBgIndex].classList.add("active")
  }, 5000)
}


document.addEventListener("DOMContentLoaded", () => {
  initBackgroundSlideshow()

  document.querySelectorAll('input[name="itinerary"]').forEach((radio) => {
    radio.addEventListener("change", handleItineraryChange)
  })
  initFlightSelection()
  showStep(1)
})

function initFlightSelection() {
  document.querySelectorAll(".flight-option").forEach((option, index) => {
    option.addEventListener("click", () => {
      selectFlight(
        {
          index: index,
          flightNumber: `Flight-${index + 1}`,
          departureTime: "--:--",
          arrivalTime: "--:--",
          price: "Price",
          duration: "Duration",
        },
        option,
      )
    })
  })
}

function showStep(step) {
  document.querySelectorAll(".section").forEach((section) => {
    section.classList.remove("active")
  })

  document.getElementById(`step-${step}`).classList.add("active")

  updateProgressIndicator(step)

  currentStep = step
}

function updateProgressIndicator(step) {
  document.querySelectorAll(".step").forEach((stepEl, index) => {
    const stepNumber = index + 1
    stepEl.classList.remove("active", "completed")

    if (stepNumber < step) {
      stepEl.classList.add("completed")
    } else if (stepNumber === step) {
      stepEl.classList.add("active")
    }
  })
}

function nextStep() {
  if (validateCurrentStep()) {
    if (currentStep < 5) {
      showStep(currentStep + 1)
      if (currentStep === 5) {
        populateSummary()
      }
    }
  }
}

function prevStep() {
  if (currentStep > 1) {
    showStep(currentStep - 1)
  }
}

function validateCurrentStep() {
  switch (currentStep) {
    case 1:
      return validateFlightSelection()
    case 2:
      // For booking details, we need to check if return date is needed
      if (bookingData.itinerary === "ROUND" && !bookingData.returnDate) {
        bookingData.returnDate = "TBD" // Set a placeholder if not set
      }
      return validateBookingDetails()
    case 3:
      return validateBookerDetails()
    case 4:
      return true // Passengers are optional
    default:
      return true
  }
}

function validateFlightSelection() {
  if (!selectedFlight) {
    alert("Please select a flight.")
    return false
  }

  // Save itinerary and class data
  bookingData.itinerary = document.querySelector('input[name="itinerary"]:checked').value
  bookingData.class = document.querySelector(".class-select").value
  bookingData.selectedFlight = selectedFlight

  return true
}

function validateBookingDetails() {
  // Since fields are auto-filled and disabled, we just return true
  return true
}

function validateBookerDetails() {
  const requiredFields = [
    "booker-fn",
    "booker-ln",
    "booker-passport",
    "booker-email",
    "booker-tel",
    "booker-address",
    "booker-city",
    "booker-postal",
    "booker-country",
  ]

  for (const fieldId of requiredFields) {
    const field = document.getElementById(fieldId)
    if (!field.value.trim()) {
      alert("Please fill in all required booker details.")
      field.focus()
      return false
    }
  }

  // Basic email validation
  const email = document.getElementById("booker-email").value
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailRegex.test(email)) {
    alert("Please enter a valid email address.")
    document.getElementById("booker-email").focus()
    return false
  }

  // Save data
  bookingData.bookerDetails = {
    firstName: document.getElementById("booker-fn").value,
    lastName: document.getElementById("booker-ln").value,
    passportNumber: document.getElementById("booker-passport").value,
    email: document.getElementById("booker-email").value,
    telephone: document.getElementById("booker-tel").value,
    address: document.getElementById("booker-address").value,
    city: document.getElementById("booker-city").value,
    postalCode: document.getElementById("booker-postal").value,
    country: document.getElementById("booker-country").value,
  }

  return true
}

function handleItineraryChange() {
  const itinerary = document.querySelector('input[name="itinerary"]:checked').value
  const returnDateGroup = document.getElementById("return-date-group")

  // Update booking data
  bookingData.itinerary = itinerary

  // Handle return date visibility in booking details page
  if (itinerary === "ONEWAY") {
    returnDateGroup.classList.add("hidden")
    document.getElementById("return-date").value = ""
    bookingData.returnDate = ""
  } else {
    returnDateGroup.classList.remove("hidden")
  }
}

function selectFlight(flight, element) {
  // Remove previous selection
  document.querySelectorAll(".flight-option").forEach((option) => {
    option.classList.remove("selected")
  })

  // Select current flight
  element.classList.add("selected")
  selectedFlight = {
    index: flight.index,
    flightNumber: flight.flightNumber,
    departureTime: flight.departureTime,
    arrivalTime: flight.arrivalTime,
    price: flight.price,
    duration: flight.duration,
  }
}

function addPassenger() {
  passengerCount++
  const container = document.getElementById("passengers-container")

  const passengerCard = document.createElement("div")
  passengerCard.className = "passenger-card"
  passengerCard.id = `passenger-${passengerCount}`

  passengerCard.innerHTML = `
        <div class="passenger-header">
            <h4 class="passenger-title">Passenger ${passengerCount}</h4>
            <button class="remove-btn" onclick="removePassenger(${passengerCount})">
                <i class="fas fa-trash"></i> Remove
            </button>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">First Name *</label>
                <input type="text" class="form-input passenger-fn" placeholder="Enter first name" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">Last Name *</label>
                <input type="text" class="form-input passenger-ln" placeholder="Enter last name" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">Birth Date</label>
                <input type="date" class="form-input passenger-bd" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">
                    Passport Number *
                    <span class="field-hint">e.g., P2658972A, AB123456, etc.</span>
                </label>
                <input type="text" class="form-input passenger-passport" placeholder="e.g., P2658972A" data-passenger="${passengerCount}">
            </div>
            <div class="form-group">
                <label class="form-label">Passport Expiry</label>
                <input type="date" class="form-input passenger-expiry" data-passenger="${passengerCount}">
            </div>
        </div>
    `

  container.appendChild(passengerCard)
}

function removePassenger(id) {
  const passengerCard = document.getElementById(`passenger-${id}`)
  if (passengerCard) {
    passengerCard.remove()
  }
}

function populateSummary() {
  // Generate simple auto-incrementing booking ID
  document.getElementById("summary-booking-id").textContent = bookingIdCounter

  // Flight details
  document.getElementById("summary-flight-number").textContent = selectedFlight ? selectedFlight.flightNumber : "N/A"
  document.getElementById("summary-from").textContent = bookingData.departureFrom || "Departure"
  document.getElementById("summary-to").textContent = bookingData.arrivalTo || "Arrival"
  document.getElementById("summary-departure-date").textContent = bookingData.departureDate || "TBD"
  document.getElementById("summary-class").textContent = bookingData.class.replace("_", " ")
  document.getElementById("summary-itinerary").textContent = bookingData.itinerary

  // Handle return date
  const returnRow = document.getElementById("summary-return-row")
  if (bookingData.itinerary === "ROUND") {
    document.getElementById("summary-return-date").textContent = bookingData.returnDate || "TBD"
    returnRow.style.display = "flex"
  } else {
    returnRow.style.display = "none"
  }

  // Booker details
  const bookerContainer = document.getElementById("summary-booker")
  bookerContainer.innerHTML = `
        <div class="detail-item">
            <i class="fas fa-user"></i>
            <div>
                <span class="detail-label">Name</span>
                <span class="detail-value">${bookingData.bookerDetails.firstName} ${bookingData.bookerDetails.lastName}</span>
            </div>
        </div>
        <div class="detail-item">
            <i class="fas fa-passport"></i>
            <div>
                <span class="detail-label">Passport</span>
                <span class="detail-value">${bookingData.bookerDetails.passportNumber}</span>
            </div>
        </div>
        <div class="detail-item">
            <i class="fas fa-envelope"></i>
            <div>
                <span class="detail-label">Email</span>
                <span class="detail-value">${bookingData.bookerDetails.email}</span>
            </div>
        </div>
        <div class="detail-item">
            <i class="fas fa-phone"></i>
            <div>
                <span class="detail-label">Phone</span>
                <span class="detail-value">${bookingData.bookerDetails.telephone}</span>
            </div>
        </div>
        <div class="detail-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <span class="detail-label">Address</span>
                <span class="detail-value">${bookingData.bookerDetails.address}, ${bookingData.bookerDetails.city}, ${bookingData.bookerDetails.country}</span>
            </div>
        </div>
    `

  // Passengers
  const passengersContainer = document.getElementById("summary-passengers")
  const passengerCards = document.querySelectorAll(".passenger-card")

  if (passengerCards.length === 0) {
    passengersContainer.innerHTML =
      '<div class="detail-item"><i class="fas fa-info-circle"></i><div><span class="detail-label">Status</span><span class="detail-value">No passengers added</span></div></div>'
  } else {
    let passengersHTML = ""
    passengerCards.forEach((card, index) => {
      const firstName = card.querySelector(".passenger-fn").value
      const lastName = card.querySelector(".passenger-ln").value
      const passport = card.querySelector(".passenger-passport").value
      const ticketId = "A" + String(index + 1).padStart(3, "0")

      if (firstName && lastName) {
        passengersHTML += `
                    <div class="detail-item">
                        <i class="fas fa-user-friends"></i>
                        <div>
                            <span class="detail-label">Passenger ${index + 1}</span>
                            <span class="detail-value">${firstName} ${lastName}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-ticket-alt"></i>
                        <div>
                            <span class="detail-label">Ticket ID</span>
                            <span class="detail-value">${ticketId}</span>
                        </div>
                    </div>
                    ${passport ? `<div class="detail-item"><i class="fas fa-passport"></i><div><span class="detail-label">Passport</span><span class="detail-value">${passport}</span></div></div>` : ""}
                `
      }
    })
    passengersContainer.innerHTML =
      passengersHTML ||
      '<div class="detail-item"><i class="fas fa-info-circle"></i><div><span class="detail-label">Status</span><span class="detail-value">No passenger details provided</span></div></div>'
  }
}

function confirmBooking() {
  // Increment booking ID for next booking
  bookingIdCounter++

  alert(
    `🎉 Booking Confirmed!\n\nBooking ID: ${bookingIdCounter - 1}\nYour booking has been successfully confirmed. You will receive a confirmation email shortly with your ticket details.\n\nThank you for choosing EasyFly!`,
  )

  // Reset form for next booking
  resetForm()
}

function resetForm() {
  // Reset to step 1
  showStep(1)

  // Clear selection
  document.querySelectorAll(".flight-option").forEach((option) => {
    option.classList.remove("selected")
  })

  // Reset radio buttons and selects
  document.querySelector('input[name="itinerary"][value="ROUND"]').checked = true
  document.querySelector(".class-select").value = "ECONOMY"

  // Clear booker details
  const bookerFields = [
    "booker-fn",
    "booker-ln",
    "booker-passport",
    "booker-email",
    "booker-tel",
    "booker-address",
    "booker-city",
    "booker-postal",
    "booker-country",
  ]
  bookerFields.forEach((fieldId) => {
    document.getElementById(fieldId).value = ""
  })

  // Clear passengers
  document.getElementById("passengers-container").innerHTML = ""
  passengerCount = 0
  selectedFlight = null

  // Reset booking data
  bookingData.itinerary = "ROUND"
  bookingData.class = "ECONOMY"
  bookingData.departureFrom = ""
  bookingData.arrivalTo = ""
  bookingData.departureDate = ""
  bookingData.returnDate = ""
  bookingData.selectedFlight = null
  bookingData.bookerDetails = {}
  bookingData.passengers = []

  // Show return date group
  document.getElementById("return-date-group").classList.remove("hidden")
}

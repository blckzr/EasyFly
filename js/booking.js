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

// Enhanced sample flight data
const sampleFlights = [
  {
    flightNumber: "MNLTKY-1730",
    airline: "EasyFly Airlines",
    aircraft: "Boeing 777-300ER",
    departureTime: "07:30",
    arrivalTime: "15:45",
    price: "₱25,500",
    duration: "3h 15m",
    baggage: "23kg",
    meals: "Included",
    wifi: "Available",
  },
  {
    flightNumber: "MNLTKY-1845",
    airline: "EasyFly Airlines",
    aircraft: "Airbus A350-900",
    departureTime: "12:15",
    arrivalTime: "20:30",
    price: "₱28,750",
    duration: "3h 15m",
    baggage: "23kg",
    meals: "Included",
    wifi: "Available",
  },
  {
    flightNumber: "MNLTKY-2100",
    airline: "EasyFly Airlines",
    aircraft: "Boeing 787-9",
    departureTime: "18:45",
    arrivalTime: "03:00+1",
    price: "₱23,200",
    duration: "3h 15m",
    baggage: "23kg",
    meals: "Included",
    wifi: "Available",
  },
]

// Background slideshow
function initBackgroundSlideshow() {
  setInterval(() => {
    const slides = document.querySelectorAll(".bg-slide")
    slides[currentBgIndex].classList.remove("active")
    currentBgIndex = (currentBgIndex + 1) % slides.length
    slides[currentBgIndex].classList.add("active")
  }, 5000)
}

// Initialize
document.addEventListener("DOMContentLoaded", () => {
  // Initialize background slideshow
  initBackgroundSlideshow()

  // Set minimum date to today
  const today = new Date().toISOString().split("T")[0]
  document.getElementById("departure-date").min = today
  document.getElementById("return-date").min = today

  // Add event listeners
  document.querySelectorAll('input[name="itinerary"]').forEach((radio) => {
    radio.addEventListener("change", handleItineraryChange)
  })

  // Initialize with first step
  showStep(1)
})

function showStep(step) {
  // Hide all sections
  document.querySelectorAll(".section").forEach((section) => {
    section.classList.remove("active")
  })

  // Show current section
  document.getElementById(`step-${step}`).classList.add("active")

  // Update progress indicator
  updateProgressIndicator(step)

  currentStep = step

  // Load flight options when reaching step 2
  if (step === 2) {
    loadFlightOptions()
  }
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
      return validateBookingDetails()
    case 2:
      return validateFlightSelection()
    case 3:
      return validateBookerDetails()
    case 4:
      return true // Passengers are optional
    default:
      return true
  }
}

function validateBookingDetails() {
  const departureFrom = document.getElementById("departure-from").value
  const arrivalTo = document.getElementById("arrival-to").value
  const departureDate = document.getElementById("departure-date").value
  const itinerary = document.querySelector('input[name="itinerary"]:checked').value
  const returnDate = document.getElementById("return-date").value

  if (!departureFrom || !arrivalTo || !departureDate) {
    alert("Please fill in all required flight details.")
    return false
  }

  if (departureFrom === arrivalTo) {
    alert("Departure and arrival locations cannot be the same.")
    return false
  }

  if (itinerary === "ROUND" && !returnDate) {
    alert("Please select a return date for round trip.")
    return false
  }

  if (itinerary === "ROUND" && returnDate && new Date(returnDate) <= new Date(departureDate)) {
    alert("Return date must be after departure date.")
    return false
  }

  // Save data
  bookingData.itinerary = itinerary
  bookingData.class = document.querySelector(".class-select").value
  bookingData.departureFrom = departureFrom
  bookingData.arrivalTo = arrivalTo
  bookingData.departureDate = departureDate
  bookingData.returnDate = returnDate

  return true
}

function validateFlightSelection() {
  if (!selectedFlight) {
    alert("Please select a flight.")
    return false
  }
  bookingData.selectedFlight = selectedFlight
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

  if (itinerary === "ONEWAY") {
    returnDateGroup.classList.add("hidden")
    document.getElementById("return-date").value = ""
  } else {
    returnDateGroup.classList.remove("hidden")
  }
}

function swapLocations() {
  const departureSelect = document.getElementById("departure-from")
  const arrivalSelect = document.getElementById("arrival-to")

  const tempValue = departureSelect.value
  departureSelect.value = arrivalSelect.value
  arrivalSelect.value = tempValue
}

function loadFlightOptions() {
  const container = document.getElementById("flight-options")
  container.innerHTML = ""

  sampleFlights.forEach((flight, index) => {
    const flightOption = document.createElement("div")
    flightOption.className = "flight-option"
    flightOption.onclick = () => selectFlight(flight, flightOption)

    flightOption.innerHTML = `
            <div class="flight-header">
                <div class="flight-number">${flight.flightNumber}</div>
                <div class="flight-price">${flight.price}</div>
            </div>
            <div class="flight-details">
                <div class="flight-time">
                    <div class="time">${flight.departureTime}</div>
                    <div class="airport">${bookingData.departureFrom}</div>
                </div>
                <div class="flight-duration">
                    <div class="duration-text">${flight.duration}</div>
                    <div class="duration-display">
                        <div class="duration-line"></div>
                        <i class="fas fa-plane duration-plane"></i>
                        <div class="duration-line"></div>
                    </div>
                </div>
                <div class="flight-time">
                    <div class="time">${flight.arrivalTime}</div>
                    <div class="airport">${bookingData.arrivalTo}</div>
                </div>
            </div>
            <div class="flight-info">
                <div class="info-item">
                    <i class="fas fa-building"></i>
                    <span>${flight.airline}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-plane"></i>
                    <span>${flight.aircraft}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-suitcase"></i>
                    <span>${flight.baggage}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-utensils"></i>
                    <span>${flight.meals}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-wifi"></i>
                    <span>${flight.wifi}</span>
                </div>
            </div>
        `

    container.appendChild(flightOption)
  })
}

function selectFlight(flight, element) {
  // Remove previous selection
  document.querySelectorAll(".flight-option").forEach((option) => {
    option.classList.remove("selected")
  })

  // Select current flight
  element.classList.add("selected")
  selectedFlight = flight
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
  document.getElementById("summary-from").textContent = bookingData.departureFrom
  document.getElementById("summary-to").textContent = bookingData.arrivalTo
  document.getElementById("summary-departure-date").textContent = bookingData.departureDate
  document.getElementById("summary-class").textContent = bookingData.class.replace("_", " ")
  document.getElementById("summary-itinerary").textContent = bookingData.itinerary

  // Handle return date
  const returnRow = document.getElementById("summary-return-row")
  if (bookingData.itinerary === "ROUND" && bookingData.returnDate) {
    document.getElementById("summary-return-date").textContent = bookingData.returnDate
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

  // Clear form data
  document.getElementById("departure-from").value = ""
  document.getElementById("arrival-to").value = ""
  document.getElementById("departure-date").value = ""
  document.getElementById("return-date").value = ""
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

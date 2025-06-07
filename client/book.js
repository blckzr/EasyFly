function showSection(id) {
    document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
    document.getElementById(id).style.display = 'block';
}

function searchFlight() {
    showSection('flight-section');
}

function addPassengerForm() {
    if (!window.passengerCount) passengerCount = 0;
    passengerCount++;

    const container = document.getElementById('passenger-form-container');
    const div = document.createElement('div');
    div.classList.add('passenger-form');
    div.innerHTML = `
        <h4>Passenger ${passengerCount}</h4>
        <label>First Name*</label>
        <input type="text" placeholder="First Name*" class="passenger-fn">
        <label>Last Name*</label>
        <input type="text" placeholder="Last Name*" class="passenger-ln">
        <label>Birth Date</label>
        <input type="date" class="passenger-bd">
        <label>Passport Number*</label>
        <input type="text" placeholder="Passport Number*" class="passenger-passport">
        <label>Passport Expiry</label>
        <input type="date" class="passenger-expiry">
        <hr>
    `;
    container.appendChild(div);
}

function populateSummary() {
    document.getElementById('booking-id').textContent = 'EF' + Math.floor(Math.random() * 100000);

    const fNames = document.querySelectorAll('.passenger-fn');
    const lNames = document.querySelectorAll('.passenger-ln');
    let names = '';
    fNames.forEach((el, i) => {
        names += `${el.value} ${lNames[i].value}, `;
    });
    document.getElementById('passenger-names').textContent = names.length > 0 ? names.slice(0, -2) : 'No passengers';

    document.getElementById('summary-itinerary').textContent = document.querySelector('input[name="itinerary"]:checked').value;
    document.getElementById('summary-class').textContent = document.querySelector('input[name="class"]:checked').value;
    document.getElementById('summary-departure-date').textContent = document.getElementById('departure-date').value;
    document.getElementById('summary-arrival-date').textContent = document.getElementById('arrival-date').value;
}

function updateArrivalField() {
    const itinerary = document.querySelector('input[name="itinerary"]:checked');
    const arrivalDate = document.getElementById('arrival-date');
    if (itinerary && itinerary.value === 'One Way') {
        arrivalDate.value = '';
        arrivalDate.disabled = true;
    } else {
        arrivalDate.disabled = false;
    }
}

document.querySelectorAll('input[name="itinerary"]').forEach(radio => {
    radio.addEventListener('change', function () {
        updateArrivalField();
    });
});

window.onload = () => {
    addPassengerForm();
    updateArrivalField();
};

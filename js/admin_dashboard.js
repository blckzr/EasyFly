const totPassengers = document.getElementById("total-passengers");
fetch("../admin/dashboard_utils/get_tot_pass.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
    totPassengers.textContent = data.total_passengers;
  });

const totFlights = document.getElementById("total-flights");
fetch("../admin/dashboard_utils/get_tot_flights.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
    totFlights.textContent = data.total_flights;
  });

const container = document.getElementById("graph-container");
const weeklyFlights = document.getElementById("weekly-flights");

fetch("../admin/dashboard_utils/get_weekly_flights.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);

    data.forEach((flight) => {
      const flightElement = document.createElement("tr");
      flightElement.innerHTML = `
            <td>${flight.weekday}</td>
            <td>${flight.flight_num}</td>
        `;
      weeklyFlights.appendChild(flightElement);
    });
  });

fetch("../admin/dashboard_utils/get_monthly_pass.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);

    const width = container.offsetWidth;
    const height = width * 0.6;

    const svg = d3
      .select("#graph-container")
      .append("svg")
      .attr("viewBox", `0 0 ${width} ${height}`)
      .attr("preserveAspectRatio", "xMidYMid meet");

    const margin = { top: 20, right: 30, bottom: 40, left: 40 };
    const innerWidth = width - margin.left - margin.right;
    const innerHeight = height - margin.top - margin.bottom;

    const g = svg
      .append("g")
      .attr("transform", `translate(${margin.left},${margin.top})`);

    const x = d3
      .scaleBand()
      .domain(data.map((d) => d.month))
      .range([0, innerWidth])
      .padding(0.1);

    const y = d3
      .scaleLinear()
      .domain([0, d3.max(data, (d) => d.pass_count)])
      .range([innerHeight, 0]);

    g.append("g")
      .attr("transform", `translate(0, ${innerHeight})`)
      .call(d3.axisBottom(x));

    g.append("g").call(d3.axisLeft(y));

    g.selectAll("rect")
      .data(data)
      .enter()
      .append("rect")
      .attr("x", (d) => x(d.month))
      .attr("y", (d) => y(d.pass_count))
      .attr("width", x.bandwidth())
      .attr("height", (d) => innerHeight - y(d.pass_count))
      .attr("fill", "#60a5fa");
  });

const topDestinations = document.getElementById("top-destinations");
fetch("../admin/dashboard_utils/get_top_destinations.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);

    data.forEach((destination) => {
      const destinationElement = document.createElement("tr");
      destinationElement.innerHTML = `
            <td>${destination.FlightTo}</td>
            <td>${destination.count}</td>
        `;
      topDestinations.appendChild(destinationElement);
    });
  });

const topBookers = document.getElementById("top-bookers");
fetch("../admin/dashboard_utils/get_top_booker.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);

    data.forEach((booker) => {
      const bookerElement = document.createElement("tr");
      bookerElement.innerHTML = `
      <td>${booker.PassportNumber}</td>
      <td>${booker.total_bookings}</td?
    `;
      topBookers.appendChild(bookerElement);
    });
  });

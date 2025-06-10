<link rel="stylesheet" href="../css/footer.css">
<footer class="footer">
    <img src="../img/newlogo.png" alt="EasyFly Logo" class="footer-logo">
    <p>&copy; 2025 EasyFly. All rights reserved.</p>
    <p>
        <a href="#" onclick="toggleSection(event, 'privacy-policy')">Privacy Policy</a> |
        <a href="#" onclick="toggleSection(event, 'terms-of-service')">Terms of Service</a> |
        <a href="#">Contact Us</a>
    </p>
</footer>

<div id="policy-container" class="policy-container">

    <!-- Privacy Policy Section -->
    <div id="privacy-policy" class="policy-card">
        <h2>Privacy Policy</h2>
        <p>EasyFly values your privacy and is committed to protecting your personal data. This policy outlines how we collect, use, and safeguard your information.</p>

        <h3>1. Information We Collect</h3>
        <p>We collect essential booking details such as your name, email, phone number, and travel preferences to provide seamless services.</p>

        <h3>2. How We Use Your Information</h3>
        <p>Your data helps us facilitate bookings, improve user experience, and personalize travel recommendations.</p>

        <h3>3. Security Measures</h3>
        <p>We implement strict encryption protocols to secure your data against unauthorized access.</p>

        <h3>4. Third-Party Sharing</h3>
        <p>EasyFly collaborates with airlines and travel partners, ensuring compliance with data protection laws.</p>

        <h3>5. Your Rights</h3>
        <p>You can request to update or delete your personal details at any time by contacting our support team.</p>

        <h3>6. Contact Us</h3>
        <p>For privacy-related inquiries, email us at <a href="mailto:privacy@easyfly.com">privacy@easyfly.com</a></p>
        <div class="button-wrapper">
            <button class="close-btn" onclick="closePolicy()">Close</button>
        </div>
    </div>

    <!-- Terms of Service Section -->
    <div id="terms-of-service" class="policy-card">
        <h2>Terms of Service</h2>
        <p>By using EasyFly, you agree to our service policies. These terms ensure a transparent and smooth booking experience.</p>

        <h3>1. Booking Policies</h3>
        <p>All flight bookings are subject to airline availability and potential price variations.</p>

        <h3>2. User Responsibilities</h3>
        <p>Users must provide accurate details. EasyFly is not responsible for booking errors due to incorrect information.</p>

        <h3>3. Payment & Refunds</h3>
        <p>Payments are securely processed, with refunds subject to airline policies.</p>

        <h3>4. Liability Limitations</h3>
        <p>EasyFly acts as a booking platform and does not control airline operations, delays, or cancellations.</p>

        <h3>5. Modifications to Terms</h3>
        <p>We reserve the right to update these terms. Continued use implies acceptance of any changes.</p>

        <h3>6. Contact Information</h3>
        <p>For questions about our terms, reach us at <a href="mailto:support@easyfly.com">support@easyfly.com</a></p>
        <div class="button-wrapper">
            <button class="close-btn" onclick="closePolicy()">Close</button>
        </div>
    </div>
</div>

<script>
    // Toggle Policy Sections
    function toggleSection(event, sectionId) {
        event.preventDefault();

        const container = document.getElementById("policy-container");
        const privacy = document.getElementById("privacy-policy");
        const terms = document.getElementById("terms-of-service");

        // Hide both sections first
        privacy.style.display = "none";
        terms.style.display = "none";

        // Show the container and the selected section
        container.classList.add("show");

        if (sectionId === "privacy-policy") {
            privacy.style.display = "block";
        } else if (sectionId === "terms-of-service") {
            terms.style.display = "block";
        }
    }

    // Close Policy Container
    function closePolicy() {
        const container = document.getElementById("policy-container");
        const privacy = document.getElementById("privacy-policy");
        const terms = document.getElementById("terms-of-service");

        container.classList.remove("show");
        privacy.style.display = "none";
        terms.style.display = "none";
    }
</script>
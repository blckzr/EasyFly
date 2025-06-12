<link rel="stylesheet" href="../css/newhome.css">
<!-- Footer -->
<footer class="new-footer">
    <div class="footer-container">
        <!-- Left Section -->
        <div class="footer-left">
            <div class="footer-logo-section">
                <img src="../img/newlogo.png" alt="EasyFly Logo" class="footer-logo" id="footer-logo">
                <p class="footer-tagline">Your Travel Partner</p>
            </div>

            <div class="footer-about">
                <h3>About Us</h3>
                <p>We want to help bring talented travelers and unique destinations together with the best flight deals and exceptional service.</p>
            </div>

            <div class="footer-contact">
                <h3>Contact Us</h3>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+63 123 456 789</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@easyfly.com</span>
                </div>
            </div>
        </div>

        <!-- Middle Section -->
        <div class="footer-middle">
            <h3>Information</h3>
            <ul class="footer-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">Book</a></li>
                <li><a href="#">View Bookings</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </div>

        <!-- Right Section -->
        <div class="footer-right">
            <h3>Helpful Links</h3>
            <ul class="footer-links">
                <li><a href="#" class="privacy-link" onclick="toggleSection(event, 'privacy-policy')">Privacy Policy</a></li>
                <li><a href="#" class="terms-link" onclick="toggleSection(event, 'terms-of-service')">Terms of Service</a></li>
                <li><a href="#" class="contact-link">Contact Support</a></li>
            </ul>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <div class="social-icons">
                <a href="#" aria-label="Facebook" class="social-icon" data-platform="facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" aria-label="Twitter" class="social-icon" data-platform="twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" aria-label="Instagram" class="social-icon" data-platform="instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" aria-label="LinkedIn" class="social-icon" data-platform="linkedin">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <div class="copyright">
                <p>2025 © EasyFly Ltd. All Rights reserved</p>
            </div>
            <div class="back-to-top">
                <button id="back-to-top-btn" aria-label="Back to top">
                    <i class="fas fa-arrow-up"></i>
                </button>
            </div>
        </div>
    </div>
</footer>

<!-- Contact Modal -->
<div id="contact-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Contact Us</h2>
            <button class="close-modal" id="close-contact-btn">&times;</button>
        </div>

        <div class="modal-body">
            <p>We'd love to hear from you! Please fill out the form below and our team will get back to you as soon as possible.</p>

            <form id="contact-form" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name">Name *</label>
                        <input type="text" id="contact-name" name="name" required>
                        <span class="error-message" id="name-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="contact-email">Email *</label>
                        <input type="email" id="contact-email" name="email" required>
                        <span class="error-message" id="email-error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="contact-subject">Subject *</label>
                    <select id="contact-subject" name="subject" required>
                        <option value="" disabled selected>Select a subject</option>
                        <option value="booking">Flight Booking Inquiry</option>
                        <option value="support">Customer Support</option>
                        <option value="feedback">Feedback</option>
                        <option value="partnership">Partnership</option>
                        <option value="other">Other</option>
                    </select>
                    <span class="error-message" id="subject-error"></span>
                </div>

                <div class="form-group">
                    <label for="contact-message">Message *</label>
                    <textarea id="contact-message" name="message" rows="5" required></textarea>
                    <span class="error-message" id="message-error"></span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn" id="contact-submit-btn">
                        <span class="btn-text">Send Message</span>
                        <span class="btn-loader"></span>
                    </button>
                    <button type="button" class="cancel-btn" id="cancel-contact-btn">Cancel</button>
                </div>
            </form>

            <div id="contact-success" class="success-message">
                <div class="success-icon">✓</div>
                <h3>Thank you for contacting us!</h3>
                <p>We've received your message and will get back to you within 24 hours.</p>
                <button class="close-btn" id="close-success-btn">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Deal Modal -->
<div id="deal-modal" class="modal">
    <div class="modal-content deal-modal-content">
        <div class="modal-header">
            <h2 id="deal-modal-title">Flight Deal Details</h2>
            <button class="close-modal" id="close-deal-btn">&times;</button>
        </div>

        <div class="modal-body">
            <div class="deal-modal-layout">
                <div class="deal-modal-image">
                    <img id="deal-modal-img" src="../img/Dubai.jpg" alt="Destination">
                    <div class="deal-modal-price" id="deal-modal-price"></div>
                    <div class="deal-modal-rating" id="deal-modal-rating">
                        <i class="fas fa-star"></i>
                        <span>4.8</span>
                    </div>
                </div>

                <div class="deal-modal-info">
                    <div class="deal-modal-details">
                        <div class="detail-item">
                            <i class="fas fa-plane-departure"></i>
                            <div>
                                <h4>Departure</h4>
                                <p>Manila International Airport</p>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-plane-arrival"></i>
                            <div>
                                <h4>Arrival</h4>
                                <p id="deal-modal-destination"></p>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <h4>Best Travel Period</h4>
                                <p id="deal-modal-period"></p>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>Flight Duration</h4>
                                <p id="deal-modal-duration"></p>
                            </div>
                        </div>
                    </div>

                    <div class="deal-modal-description">
                        <h3>About this deal</h3>
                        <p id="deal-modal-description">Experience the beauty and culture of this amazing destination with our special flight deal. This offer includes direct flights, flexible booking options, and competitive prices.</p>
                        <ul class="deal-features">
                            <li><i class="fas fa-check"></i> Flexible booking options</li>
                            <li><i class="fas fa-check"></i> Free date changes</li>
                            <li><i class="fas fa-check"></i> 23kg baggage allowance</li>
                            <li><i class="fas fa-check"></i> Seat selection included</li>
                        </ul>
                    </div>

                    <div class="deal-modal-cta">
                        <button class="book-now-btn">Book Now</button>
                        <button class="save-deal-btn" id="save-deal-btn">
                            <i class="far fa-heart"></i>
                            <span>Save Deal</span>
                        </button>
                        <button class="compare-deal-btn" id="compare-deal-btn">
                            <i class="fas fa-balance-scale"></i>
                            <span>Compare</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Policy Container -->
<div id="policy-container" class="modal">
    <div class="modal-content policy-modal">
        <!-- Privacy Policy Section -->
        <div id="privacy-policy" class="policy-card">
            <div class="modal-header">
                <h2>Privacy Policy</h2>
                <button class="close-modal" onclick="closePolicy()">&times;</button>
            </div>
            <div class="modal-body">
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
            </div>
        </div>

        <!-- Terms of Service Section -->
        <div id="terms-of-service" class="policy-card">
            <div class="modal-header">
                <h2>Terms of Service</h2>
                <button class="close-modal" onclick="closePolicy()">&times;</button>
            </div>
            <div class="modal-body">
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
            </div>
        </div>
    </div>
</div>
<script src="../js/newhome.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EasyFly - Air Ticket Booking</title>
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/newhome.css">
</head>
<body>
  <?php
    $curr_page = 'home'; // Set the current page for active link highlighting
    include '../components/connect.php'; // Include the database connection 
    include '../components/header.php';
  ?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Experience the <br> World with Ease</h1>
      <p>Travel made simple — book flights whenever <br> and wherever you need.</p>
      <a href="#" class="get-started">Get Started</a>
    </div>
  </section>

  <!-- Enhanced Latest Deals Section -->
  <section class="latest-deals">
    <h2 class="section-title">Our Latest Deals</h2>
    <p class="section-subtitle">Discover amazing flight deals and offers.</p>
    
    <!-- Enhanced Deals Filter with Counter -->
    <div class="deals-filter">
      <button class="filter-btn active" data-filter="all">
        All Destinations <span class="filter-count">(6)</span>
      </button>
      <button class="filter-btn" data-filter="asia">
        Asia <span class="filter-count">(3)</span>
      </button>
      <button class="filter-btn" data-filter="europe">
        Europe <span class="filter-count">(2)</span>
      </button>
      <button class="filter-btn" data-filter="middle-east">
        Middle East <span class="filter-count">(1)</span>
      </button>
    </div>
    
    <!-- Swiper Slider Implementation -->
    <div class="deals-section-wrapper">
      <div class="swiper deals-swiper">
        <div class="swiper-wrapper">
          <!-- Dubai -->
          <div class="swiper-slide" data-category="middle-east">
            <div class="deal-card enhanced" data-deal-id="dubai">
              <div class="deal-badge popular">Popular</div>
              <div class="deal-image-container">
                <img src="../img/Dubai.jpg" alt="Dubai" loading="lazy">
                <div class="deal-overlay">
                  <div class="deal-quick-info">
                    <span><i class="fas fa-star"></i> 4.8 Rating</span>
                    <span><i class="fas fa-users"></i> 2,341 Bookings</span>
                  </div>
                </div>
              </div>
              <div class="deal-info">
                <div class="deal-header">
                  <h3>Dubai</h3>
                  <button class="favorite-btn" data-destination="Dubai" aria-label="Add to favorites">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                <p class="deal-price">
                  <span class="current-price">₱9,466</span>
                  <span class="original-price">₱12,000</span>
                  <span class="discount">21% OFF</span>
                </p>
                <div class="deal-details">
                  <span><i class="fas fa-plane-departure"></i> Direct flights</span>
                  <span><i class="fas fa-calendar-alt"></i> Available year-round</span>
                  <span><i class="fas fa-clock"></i> 7h 30m flight</span>
                </div>
                <div class="deal-actions">
                  <button class="view-deal-btn primary">View Deal</button>
                  <button class="quick-book-btn" data-destination="Dubai">Quick Book</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Paris -->
          <div class="swiper-slide" data-category="europe">
            <div class="deal-card enhanced" data-deal-id="paris">
              <div class="deal-badge discount">20% OFF</div>
              <div class="deal-image-container">
                <img src="../img/paris.jpg" alt="Paris" loading="lazy">
                <div class="deal-overlay">
                  <div class="deal-quick-info">
                    <span><i class="fas fa-star"></i> 4.9 Rating</span>
                    <span><i class="fas fa-users"></i> 1,876 Bookings</span>
                  </div>
                </div>
              </div>
              <div class="deal-info">
                <div class="deal-header">
                  <h3>Paris</h3>
                  <button class="favorite-btn" data-destination="Paris" aria-label="Add to favorites">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                <p class="deal-price">
                  <span class="current-price">₱16,682</span>
                  <span class="original-price">₱20,850</span>
                  <span class="discount">20% OFF</span>
                </p>
                <div class="deal-details">
                  <span><i class="fas fa-plane-departure"></i> 1 stop</span>
                  <span><i class="fas fa-calendar-alt"></i> Best in Spring</span>
                  <span><i class="fas fa-clock"></i> 14h 20m flight</span>
                </div>
                <div class="deal-actions">
                  <button class="view-deal-btn primary">View Deal</button>
                  <button class="quick-book-btn" data-destination="Paris">Quick Book</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Bangkok -->
          <div class="swiper-slide" data-category="asia">
            <div class="deal-card enhanced" data-deal-id="bangkok">
              <div class="deal-badge hot">Hot Deal</div>
              <div class="deal-image-container">
                <img src="../img/bangkok.jpg" alt="Bangkok" loading="lazy">
                <div class="deal-overlay">
                  <div class="deal-quick-info">
                    <span><i class="fas fa-star"></i> 4.7 Rating</span>
                    <span><i class="fas fa-users"></i> 3,124 Bookings</span>
                  </div>
                </div>
              </div>
              <div class="deal-info">
                <div class="deal-header">
                  <h3>Bangkok</h3>
                  <button class="favorite-btn" data-destination="Bangkok" aria-label="Add to favorites">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                <p class="deal-price">
                  <span class="current-price">₱2,829</span>
                  <span class="original-price">₱4,200</span>
                  <span class="discount">33% OFF</span>
                </p>
                <div class="deal-details">
                  <span><i class="fas fa-plane-departure"></i> Direct flights</span>
                  <span><i class="fas fa-calendar-alt"></i> Best in November</span>
                  <span><i class="fas fa-clock"></i> 3h 45m flight</span>
                </div>
                <div class="deal-actions">
                  <button class="view-deal-btn primary">View Deal</button>
                  <button class="quick-book-btn" data-destination="Bangkok">Quick Book</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Maldives -->
          <div class="swiper-slide" data-category="asia">
            <div class="deal-card enhanced" data-deal-id="maldives">
              <div class="deal-badge luxury">Luxury</div>
              <div class="deal-image-container">
                <img src="../img/Maldives.jpg" alt="Maldives" loading="lazy">
                <div class="deal-overlay">
                  <div class="deal-quick-info">
                    <span><i class="fas fa-star"></i> 4.9 Rating</span>
                    <span><i class="fas fa-users"></i> 987 Bookings</span>
                  </div>
                </div>
              </div>
              <div class="deal-info">
                <div class="deal-header">
                  <h3>Maldives</h3>
                  <button class="favorite-btn" data-destination="Maldives" aria-label="Add to favorites">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                <p class="deal-price">
                  <span class="current-price">₱8,733</span>
                  <span class="original-price">₱11,500</span>
                  <span class="discount">24% OFF</span>
                </p>
                <div class="deal-details">
                  <span><i class="fas fa-plane-departure"></i> 1 stop</span>
                  <span><i class="fas fa-calendar-alt"></i> Best in Winter</span>
                  <span><i class="fas fa-clock"></i> 9h 15m flight</span>
                </div>
                <div class="deal-actions">
                  <button class="view-deal-btn primary">View Deal</button>
                  <button class="quick-book-btn" data-destination="Maldives">Quick Book</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Rome -->
          <div class="swiper-slide" data-category="europe">
            <div class="deal-card enhanced" data-deal-id="rome">
              <div class="deal-badge new">New</div>
              <div class="deal-image-container">
                <img src="https://images.unsplash.com/photo-1552832230-c0197dd311b5?q=80&w=1000&auto=format&fit=crop" alt="Rome" loading="lazy">
                <div class="deal-overlay">
                  <div class="deal-quick-info">
                    <span><i class="fas fa-star"></i> 4.8 Rating</span>
                    <span><i class="fas fa-users"></i> 1,543 Bookings</span>
                  </div>
                </div>
              </div>
              <div class="deal-info">
                <div class="deal-header">
                  <h3>Rome</h3>
                  <button class="favorite-btn" data-destination="Rome" aria-label="Add to favorites">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                <p class="deal-price">
                  <span class="current-price">₱18,500</span>
                  <span class="original-price">₱23,000</span>
                  <span class="discount">20% OFF</span>
                </p>
                <div class="deal-details">
                  <span><i class="fas fa-plane-departure"></i> 1 stop</span>
                  <span><i class="fas fa-calendar-alt"></i> Best in Summer</span>
                  <span><i class="fas fa-clock"></i> 15h 30m flight</span>
                </div>
                <div class="deal-actions">
                  <button class="view-deal-btn primary">View Deal</button>
                  <button class="quick-book-btn" data-destination="Rome">Quick Book</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Tokyo -->
          <div class="swiper-slide" data-category="asia">
            <div class="deal-card enhanced" data-deal-id="tokyo">
              <div class="deal-badge seasonal">Cherry Blossom</div>
              <div class="deal-image-container">
                <img src="https://images.unsplash.com/photo-1536098561742-ca998e48cbcc?q=80&w=1000&auto=format&fit=crop" alt="Tokyo" loading="lazy">
                <div class="deal-overlay">
                  <div class="deal-quick-info">
                    <span><i class="fas fa-star"></i> 4.8 Rating</span>
                    <span><i class="fas fa-users"></i> 2,087 Bookings</span>
                  </div>
                </div>
              </div>
              <div class="deal-info">
                <div class="deal-header">
                  <h3>Tokyo</h3>
                  <button class="favorite-btn" data-destination="Tokyo" aria-label="Add to favorites">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                <p class="deal-price">
                  <span class="current-price">₱12,400</span>
                  <span class="original-price">₱15,800</span>
                  <span class="discount">22% OFF</span>
                </p>
                <div class="deal-details">
                  <span><i class="fas fa-plane-departure"></i> Direct flights</span>
                  <span><i class="fas fa-calendar-alt"></i> Cherry blossom season</span>
                  <span><i class="fas fa-clock"></i> 3h 20m flight</span>
                </div>
                <div class="deal-actions">
                  <button class="view-deal-btn primary">View Deal</button>
                  <button class="quick-book-btn" data-destination="Tokyo">Quick Book</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Add navigation arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Pagination dots only -->
        <div class="swiper-pagination"></div>
      </div>
    </div>
    
    <!-- Deal Comparison Tool -->
    <div class="deal-comparison" id="deal-comparison">
      <div class="comparison-header">
        <h3>Compare Selected Deals</h3>
        <button class="clear-comparison" id="clear-comparison">Clear All</button>
      </div>
      <div class="comparison-content" id="comparison-content">
        <p class="comparison-empty">Select deals to compare prices and features</p>
      </div>
    </div>
  </section>

  <!-- Company Ad Section -->
  <section class="promo-section">
    <div class="promo-content">
      <div class="promo-text">
        <h2>Why Choose EasyFly?</h2>
        <p>We offer the best flight deals, easy booking, and exceptional customer service.
          With EasyFly, you enjoy a user-friendly platform that makes booking flights simple and quick. 
          Our extensive network of destinations ensures you find the perfect trip, whether you're traveling for business or leisure.</p>
        <p>Join millions of satisfied travelers who trust EasyFly for their flight bookings.</p>
        
        <!-- Feature Icons -->
        <div class="promo-features">
          <div class="feature">
            <i class="fas fa-tag"></i>
            <span>Best Price Guarantee</span>
          </div>
          <div class="feature">
            <i class="fas fa-headset"></i>
            <span>24/7 Customer Support</span>
          </div>
          <div class="feature">
            <i class="fas fa-shield-alt"></i>
            <span>Secure Booking</span>
          </div>
        </div>
        
        <a href="#" class="learn-btn">Learn more</a>
      </div>
      <div class="promo-image">
        <img src="../img/promopic.jpg" alt="Airport view">
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="gallery-section">
    <h2>Travellers' Choice: <span>Most Visited Destinations</span></h2>
    <div class="gallery-grid">
      <div class="destination-card">
        <img src="../img/France.jpg" alt="France">
        <div class="card-info">
          <h3>France</h3>
          <p>102M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <div class="destination-card">
        <img src="../img/Spain.jpg" alt="Spain">
        <div class="card-info">
          <h3>Spain</h3>
          <p>93.8M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <div class="destination-card">
        <img src="../img/USA.jpg" alt="United States">
        <div class="card-info">
          <h3>United States</h3>
          <p>72.4M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <div class="destination-card">
        <img src="../img/Turkey.jpg" alt="Turkey">
        <div class="card-info">
          <h3>Turkey</h3>
          <p>60.6M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <div class="destination-card">
        <img src="../img/Italy.jpg" alt="Italy">
        <div class="card-info">
          <h3>Italy</h3>
          <p>57.7M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <div class="destination-card">
        <img src="../img/Mexico.jpg" alt="Mexico">
        <div class="card-info">
          <h3>Mexico</h3>
          <p>45M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <!-- Hidden cards (will be shown with View All) -->
      <div class="destination-card hidden-card">
        <img src="../img/Germany.jpg" alt="Germany">
        <div class="card-info">
          <h3>Germany</h3>
          <p>37.5M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <div class="destination-card hidden-card">
        <img src="../img/Japan.jpg" alt="Japan">
        <div class="card-info">
          <h3>Japan</h3>
          <p>36.9M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
      <div class="destination-card hidden-card">
        <img src="../img/Greece.jpg" alt="Greece">
        <div class="card-info">
          <h3>Greece</h3>
          <p>35.8M visitors</p>
          <div class="card-overlay">
            <button class="explore-btn">Explore Deals</button>
          </div>
        </div>
      </div>
    </div>
    <div class="view-all-button">
      <button id="view-all-btn" onclick="showAllDestinations()">View All Destinations</button>
    </div>
  </section>

  <!-- Booking Banner Section -->
  <section class="booking-banner-section">
    <div class="banner-container">
      <div class="banner-content">
        <div class="banner-icon">
          <i class="fas fa-plane-departure"></i>
        </div>
        <div class="banner-text">
          <h3>Ready for Your Next Adventure?</h3>
          <p>Don't miss out on these amazing flight deals. Book now and save up to 35% on your next trip!</p>
        </div>
        <div class="banner-cta">
          <a href="#" class="book-now-banner-btn">Book Now</a>
          <span class="banner-offer">Limited Time Offer!</span>
        </div>
      </div>
    </div>
  </section>

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

  <!-- Toast Notifications -->
  <div id="toast-container" class="toast-container"></div>

  <!-- Loading Overlay -->
  <div id="loading-overlay" class="loading-overlay">
    <div class="loader"></div>
  </div>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <!-- Custom Scripts -->
  <script src="../js/newhome.js"></script>
</body>
</html>

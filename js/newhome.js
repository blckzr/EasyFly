// Enhanced EasyFly Website JavaScript with COMPLETELY FIXED Swiper Integration
// Using global Swiper object from CDN

class EnhancedEasyFlyWebsite {
  constructor() {
    this.dealsSwiper = null
    this.allSlides = []
    this.isTransitioning = false
    this.favorites = new Set()
    this.comparedDeals = new Set()

    this.init()
  }

  init() {
    this.bindEvents()
    this.initSwiperDealsSlider()
    this.initModals()
    this.initForms()
    this.initFavorites()
    this.initComparison()
    this.preloadImages()
  }

  bindEvents() {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", () => this.setupEventListeners())
    } else {
      this.setupEventListeners()
    }
  }

  setupEventListeners() {
    // Enhanced deals filter buttons
    const filterBtns = document.querySelectorAll(".filter-btn")
    filterBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => this.filterDeals(e.target.dataset.filter))
    })

    // Enhanced view deal buttons
    const viewDealBtns = document.querySelectorAll(".view-deal-btn")
    viewDealBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => this.openEnhancedDealModal(e.target.closest(".deal-card")))
    })

    // Quick book buttons
    const quickBookBtns = document.querySelectorAll(".quick-book-btn")
    quickBookBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => this.handleQuickBook(e.target.dataset.destination))
    })

    // Favorite buttons
    const favoriteBtns = document.querySelectorAll(".favorite-btn")
    favoriteBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => this.toggleFavorite(e.target.closest("button")))
    })

    // Comparison clear button
    const clearComparisonBtn = document.getElementById("clear-comparison")
    if (clearComparisonBtn) {
      clearComparisonBtn.addEventListener("click", () => this.clearComparison())
    }

    // Gallery explore buttons
    const exploreBtns = document.querySelectorAll(".explore-btn")
    exploreBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => this.exploreDestination(e.target))
    })

    // Back to top button
    const backToTopBtn = document.getElementById("back-to-top-btn")
    if (backToTopBtn) {
      backToTopBtn.addEventListener("click", () => this.scrollToTop())
    }

    // Social media icons
    const socialIcons = document.querySelectorAll(".social-icon")
    socialIcons.forEach((icon) => {
      icon.addEventListener("click", (e) => this.handleSocialClick(e))
    })

    // Footer links
    const contactLinks = document.querySelectorAll(".contact-link")
    contactLinks.forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault()
        this.openContactModal()
      })
    })

    // Enhanced scroll events
    window.addEventListener("scroll", () => this.handleScroll())

    // Window resize handler
    window.addEventListener("resize", () => this.handleResize())
  }

  // COMPLETELY FIXED: Swiper Deals Slider Functionality
  initSwiperDealsSlider() {
    // Wait for DOM to be ready
    if (!document.querySelector(".deals-swiper")) {
      setTimeout(() => this.initSwiperDealsSlider(), 100)
      return
    }

    // Destroy existing swiper if it exists
    if (this.dealsSwiper) {
      this.dealsSwiper.destroy(true, true)
    }

    // Initialize Swiper with simplified configuration for reliability
    this.dealsSwiper = new window.Swiper(".deals-swiper", {
      // Basic configuration
      slidesPerView: 1,
      spaceBetween: 20,

      // Disable loop initially to avoid blank space issues
      loop: false,

      // Enable rewind for seamless cycling
      rewind: true,

      // Autoplay configuration
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },

      // Navigation
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },

      // Pagination
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
      },

      // Responsive breakpoints
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
      },

      // Event handlers
      on: {
        init: () => {
          console.log("Swiper initialized successfully")
          // Ensure all slides are visible
          this.ensureSlidesVisible()
        },
        slideChange: () => {
          console.log("Slide changed")
        },
        reachEnd: () => {
          // When reaching the end, go back to start
          setTimeout(() => {
            if (this.dealsSwiper) {
              this.dealsSwiper.slideTo(0, 1000)
            }
          }, 2000)
        },
      },
    })

    // Store all slides for filtering
    this.allSlides = Array.from(document.querySelectorAll(".swiper-slide"))
    this.updateFilterCounts()

    // Ensure slides are visible after initialization
    setTimeout(() => {
      this.ensureSlidesVisible()
    }, 100)
  }

  // Ensure all slides are properly visible
  ensureSlidesVisible() {
    const slides = document.querySelectorAll(".swiper-slide")
    slides.forEach((slide) => {
      slide.style.display = "block"
      slide.style.opacity = "1"
      slide.style.visibility = "visible"
    })
  }

  // FIXED: Filter functionality with proper slide management
  filterDeals(category) {
    if (this.isTransitioning) return

    this.isTransitioning = true

    // Update active filter button
    document.querySelectorAll(".filter-btn").forEach((btn) => {
      btn.classList.remove("active")
    })

    const activeBtn = document.querySelector(`[data-filter="${category}"]`)
    activeBtn.classList.add("active")

    // Destroy current swiper
    if (this.dealsSwiper) {
      this.dealsSwiper.destroy(true, true)
    }

    // Filter slides by hiding/showing them
    this.allSlides.forEach((slide) => {
      const slideCategory = slide.dataset.category
      if (category === "all" || slideCategory === category) {
        slide.style.display = "block"
        slide.classList.remove("filtered-out")
      } else {
        slide.style.display = "none"
        slide.classList.add("filtered-out")
      }
    })

    // Reinitialize swiper with filtered slides
    setTimeout(() => {
      this.initSwiperDealsSlider()
      this.isTransitioning = false
    }, 100)

    // Update filter counts
    this.updateFilterCounts()

    // Show toast
    this.showToast(
      `Found ${this.getVisibleDealsCount(category)} amazing deals${category !== "all" ? ` in ${category.replace("-", " ")}` : ""}`,
      "info",
    )
  }

  getVisibleDealsCount(category) {
    if (category === "all") {
      return this.allSlides.length
    }
    return this.allSlides.filter((slide) => slide.dataset.category === category).length
  }

  updateFilterCounts() {
    const filterBtns = document.querySelectorAll(".filter-btn")
    filterBtns.forEach((btn) => {
      const filter = btn.dataset.filter
      let count = 0

      if (filter === "all") {
        count = this.allSlides.length
      } else {
        count = this.allSlides.filter((slide) => slide.dataset.category === filter).length
      }

      const countSpan = btn.querySelector(".filter-count")
      if (countSpan) {
        countSpan.textContent = `(${count})`
      }
    })
  }

  // Enhanced Modal Functionality
  initModals() {
    // Close modal when clicking outside (but not for policy container)
    document.addEventListener("click", (e) => {
      if (e.target.classList.contains("modal") && !e.target.id.includes("policy")) {
        this.closeModal(e.target)
      }
    })

    // Close buttons
    const closeButtons = document.querySelectorAll(".close-modal")
    closeButtons.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        const modal = e.target.closest(".modal")
        if (modal && modal.id === "policy-container") {
          closePolicy()
        } else {
          this.closeModal(modal)
        }
      })
    })
  }

  openEnhancedDealModal(dealCard) {
    const modal = document.getElementById("deal-modal")
    const dealId = dealCard.dataset.dealId
    const title = dealCard.querySelector("h3").textContent
    const img = dealCard.querySelector("img").src
    const currentPrice = dealCard.querySelector(".current-price").textContent

    // Populate enhanced modal content
    document.getElementById("deal-modal-title").textContent = `${title} Flight Deal`
    document.getElementById("deal-modal-img").src = img
    document.getElementById("deal-modal-price").textContent = currentPrice
    document.getElementById("deal-modal-destination").textContent = `${title} International Airport`

    // Set enhanced travel details
    const dealDetails = this.getDealDetails(title)
    document.getElementById("deal-modal-period").textContent = dealDetails.period
    document.getElementById("deal-modal-duration").textContent = dealDetails.duration
    document.getElementById("deal-modal-description").textContent = dealDetails.description

    // Update rating
    const ratingElement = document.getElementById("deal-modal-rating")
    if (ratingElement) {
      ratingElement.innerHTML = `<i class="fas fa-star"></i><span>${dealDetails.rating}</span>`
    }

    // Show modal with animation
    this.showModal(modal)

    // Initialize enhanced modal buttons
    this.initModalButtons(dealId, title)
  }

  getDealDetails(destination) {
    const details = {
      Dubai: {
        period: "October - April (Best Weather)",
        duration: "7h 30m direct flight",
        rating: "4.8",
        description:
          "Experience the luxury and innovation of Dubai with our exclusive flight deal. Enjoy world-class shopping, stunning architecture, and desert adventures in this modern metropolis.",
      },
      Paris: {
        period: "April - June, September - October",
        duration: "14h 20m (1 stop)",
        rating: "4.9",
        description:
          "Discover the romance and culture of Paris with our special offer. From the Eiffel Tower to the Louvre, immerse yourself in art, cuisine, and timeless elegance.",
      },
      Bangkok: {
        period: "November - February (Cool Season)",
        duration: "3h 45m direct flight",
        rating: "4.7",
        description:
          "Explore the vibrant street life and rich culture of Bangkok. Experience amazing street food, magnificent temples, and bustling markets in Thailand's capital.",
      },
      Maldives: {
        period: "November - April (Dry Season)",
        duration: "9h 15m (1 stop)",
        rating: "4.9",
        description:
          "Escape to paradise in the Maldives. Enjoy crystal-clear waters, overwater bungalows, and pristine beaches in this tropical haven.",
      },
      Rome: {
        period: "April - June, September - October",
        duration: "15h 30m (1 stop)",
        rating: "4.8",
        description:
          "Step back in time in the Eternal City. Explore ancient ruins, world-class art, and incredible cuisine in this historic Italian capital.",
      },
      Tokyo: {
        period: "March - May (Cherry Blossom)",
        duration: "3h 20m direct flight",
        rating: "4.8",
        description:
          "Experience the perfect blend of tradition and modernity in Tokyo. From ancient temples to cutting-edge technology, discover Japan's fascinating capital.",
      },
    }

    return (
      details[destination] || {
        period: "Year-round",
        duration: "Flight time varies",
        rating: "4.5",
        description: "Discover this amazing destination with our special flight deal.",
      }
    )
  }

  initModalButtons(dealId, title) {
    // Save deal button
    const saveBtn = document.getElementById("save-deal-btn")
    if (saveBtn) {
      saveBtn.replaceWith(saveBtn.cloneNode(true)) // Remove old listeners
      const newSaveBtn = document.getElementById("save-deal-btn")
      newSaveBtn.addEventListener("click", () => this.toggleSaveDeal(newSaveBtn, title))

      // Update button state
      if (this.favorites.has(dealId)) {
        newSaveBtn.classList.add("saved")
        newSaveBtn.querySelector("i").className = "fas fa-heart"
        newSaveBtn.querySelector("span").textContent = "Saved"
      }
    }

    // Compare deal button
    const compareBtn = document.getElementById("compare-deal-btn")
    if (compareBtn) {
      compareBtn.replaceWith(compareBtn.cloneNode(true)) // Remove old listeners
      const newCompareBtn = document.getElementById("compare-deal-btn")
      newCompareBtn.addEventListener("click", () => this.toggleCompareDeal(dealId, title))

      // Update button state
      if (this.comparedDeals.has(dealId)) {
        newCompareBtn.style.borderColor = "#4046be"
        newCompareBtn.style.color = "#4046be"
        newCompareBtn.querySelector("span").textContent = "Added"
      }
    }

    // Book now button
    const bookBtn = document.querySelector(".book-now-btn")
    if (bookBtn) {
      bookBtn.replaceWith(bookBtn.cloneNode(true)) // Remove old listeners
      const newBookBtn = document.querySelector(".book-now-btn")
      newBookBtn.addEventListener("click", () => this.handleBookNow(title))
    }
  }

  openContactModal() {
    const modal = document.getElementById("contact-modal")
    this.showModal(modal)

    // Reset form
    const form = document.getElementById("contact-form")
    const success = document.getElementById("contact-success")

    if (form && success) {
      form.style.display = "block"
      success.style.display = "none"
      form.reset()
      this.clearFormErrors()
    }
  }

  showModal(modal) {
    modal.style.display = "block"
    document.body.style.overflow = "hidden"

    // Add entrance animation
    const content = modal.querySelector(".modal-content")
    if (content) {
      content.style.transform = "scale(0.9) translateY(-20px)"
      content.style.opacity = "0"

      setTimeout(() => {
        content.style.transition = "all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)"
        content.style.transform = "scale(1) translateY(0)"
        content.style.opacity = "1"
      }, 10)
    }

    // Focus trap
    const focusableElements = modal.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])',
    )
    if (focusableElements.length > 0) {
      focusableElements[0].focus()
    }
  }

  closeModal(modal) {
    const content = modal.querySelector(".modal-content")
    if (content) {
      content.style.transform = "scale(0.9) translateY(-20px)"
      content.style.opacity = "0"

      setTimeout(() => {
        modal.style.display = "none"
        document.body.style.overflow = "auto"
      }, 300)
    } else {
      modal.style.display = "none"
      document.body.style.overflow = "auto"
    }
  }

  // Enhanced Form Functionality
  initForms() {
    // Contact form
    const contactForm = document.getElementById("contact-form")
    if (contactForm) {
      contactForm.addEventListener("submit", (e) => this.handleContactSubmit(e))
    }

    // Cancel buttons
    const cancelBtn = document.getElementById("cancel-contact-btn")
    const closeSuccessBtn = document.getElementById("close-success-btn")

    if (cancelBtn) {
      cancelBtn.addEventListener("click", () => {
        this.closeModal(document.getElementById("contact-modal"))
      })
    }

    if (closeSuccessBtn) {
      closeSuccessBtn.addEventListener("click", () => {
        this.closeModal(document.getElementById("contact-modal"))
      })
    }
  }

  handleContactSubmit(e) {
    e.preventDefault()

    const form = e.target
    const submitBtn = document.getElementById("contact-submit-btn")

    // Validate form
    if (!this.validateContactForm()) {
      return
    }

    // Show loading state
    this.setButtonLoading(submitBtn, true)

    // Simulate API call
    setTimeout(() => {
      this.setButtonLoading(submitBtn, false)

      // Show success message
      form.style.display = "none"
      document.getElementById("contact-success").style.display = "block"

      this.showToast("Message sent successfully!", "success")
    }, 2000)
  }

  validateContactForm() {
    const name = document.getElementById("contact-name").value.trim()
    const email = document.getElementById("contact-email").value.trim()
    const subject = document.getElementById("contact-subject").value
    const message = document.getElementById("contact-message").value.trim()

    let isValid = true

    // Clear previous errors
    this.clearFormErrors()

    // Validate name
    if (!name) {
      this.showFieldError("contact-name", "Name is required")
      isValid = false
    } else if (name.length < 2) {
      this.showFieldError("contact-name", "Name must be at least 2 characters")
      isValid = false
    }

    // Validate email
    if (!email) {
      this.showFieldError("contact-email", "Email is required")
      isValid = false
    } else if (!this.isValidEmail(email)) {
      this.showFieldError("contact-email", "Please enter a valid email")
      isValid = false
    }

    // Validate subject
    if (!subject) {
      this.showFieldError("contact-subject", "Please select a subject")
      isValid = false
    }

    // Validate message
    if (!message) {
      this.showFieldError("contact-message", "Message is required")
      isValid = false
    } else if (message.length < 10) {
      this.showFieldError("contact-message", "Message must be at least 10 characters")
      isValid = false
    } else if (message.length > 1000) {
      this.showFieldError("contact-message", "Message must be less than 1000 characters")
      isValid = false
    }

    return isValid
  }

  showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId)
    const formGroup = field.closest(".form-group")
    const errorElement = formGroup.querySelector(".error-message")

    formGroup.classList.add("error")
    errorElement.textContent = message

    // Add shake animation
    field.style.animation = "shake 0.5s ease-in-out"
    setTimeout(() => {
      field.style.animation = ""
    }, 500)
  }

  clearFormErrors() {
    const errorGroups = document.querySelectorAll(".form-group.error")
    errorGroups.forEach((group) => {
      group.classList.remove("error")
      group.querySelector(".error-message").textContent = ""
    })
  }

  isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    return emailRegex.test(email)
  }

  setButtonLoading(button, loading) {
    if (loading) {
      button.classList.add("loading")
      button.disabled = true
    } else {
      button.classList.remove("loading")
      button.disabled = false
    }
  }

  // Enhanced Favorites System
  initFavorites() {
    const savedFavorites = localStorage.getItem("easyfly-favorites")
    if (savedFavorites) {
      this.favorites = new Set(JSON.parse(savedFavorites))
      this.updateFavoriteButtons()
    }
  }

  toggleFavorite(button) {
    const destination = button.dataset.destination
    const dealCard = button.closest(".deal-card")
    const dealId = dealCard.dataset.dealId

    const icon = button.querySelector("i")

    if (this.favorites.has(dealId)) {
      this.favorites.delete(dealId)
      icon.className = "far fa-heart"
      button.classList.remove("active")
      this.showToast(`Removed ${destination} from favorites`, "info")
    } else {
      this.favorites.add(dealId)
      icon.className = "fas fa-heart"
      button.classList.add("active")
      this.showToast(`Added ${destination} to favorites`, "success")
    }

    localStorage.setItem("easyfly-favorites", JSON.stringify([...this.favorites]))
  }

  updateFavoriteButtons() {
    const favoriteButtons = document.querySelectorAll(".favorite-btn")
    favoriteButtons.forEach((button) => {
      const dealCard = button.closest(".deal-card")
      const dealId = dealCard.dataset.dealId

      if (this.favorites.has(dealId)) {
        button.classList.add("active")
        button.querySelector("i").className = "fas fa-heart"
      }
    })
  }

  // Enhanced Comparison System
  initComparison() {
    const savedComparison = sessionStorage.getItem("easyfly-comparison")
    if (savedComparison) {
      this.comparedDeals = new Set(JSON.parse(savedComparison))
      this.updateComparisonDisplay()
    }
  }

  toggleCompareDeal(dealId, title) {
    if (this.comparedDeals.has(dealId)) {
      this.comparedDeals.delete(dealId)
      this.showToast(`Removed ${title} from comparison`, "info")
    } else {
      if (this.comparedDeals.size >= 3) {
        this.showToast("You can only compare up to 3 deals", "warning")
        return
      }

      this.comparedDeals.add(dealId)
      this.showToast(`Added ${title} to comparison`, "success")
    }

    sessionStorage.setItem("easyfly-comparison", JSON.stringify([...this.comparedDeals]))
    this.updateComparisonDisplay()
  }

  clearComparison() {
    this.comparedDeals.clear()
    sessionStorage.removeItem("easyfly-comparison")
    this.updateComparisonDisplay()
    this.showToast("Comparison cleared", "info")
  }

  updateComparisonDisplay() {
    const comparisonSection = document.getElementById("deal-comparison")
    const comparisonContent = document.getElementById("comparison-content")

    if (this.comparedDeals.size === 0) {
      comparisonSection.classList.remove("active")
      return
    }

    comparisonSection.classList.add("active")
    comparisonContent.innerHTML = ""

    this.comparedDeals.forEach((dealId) => {
      const dealCard = document.querySelector(`[data-deal-id="${dealId}"]`)
      if (dealCard) {
        const comparisonItem = this.createComparisonItem(dealCard)
        comparisonContent.appendChild(comparisonItem)
      }
    })
  }

  createComparisonItem(dealCard) {
    const title = dealCard.querySelector("h3").textContent
    const price = dealCard.querySelector(".current-price").textContent
    const img = dealCard.querySelector("img").src

    const item = document.createElement("div")
    item.className = "comparison-item"
    item.innerHTML = `
      <img src="${img}" alt="${title}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
      <h4>${title}</h4>
      <p class="comparison-price">${price}</p>
      <button class="remove-comparison" data-deal-id="${dealCard.dataset.dealId}">
        <i class="fas fa-times"></i> Remove
      </button>
    `

    const removeBtn = item.querySelector(".remove-comparison")
    removeBtn.addEventListener("click", () => {
      this.comparedDeals.delete(dealCard.dataset.dealId)
      sessionStorage.setItem("easyfly-comparison", JSON.stringify([...this.comparedDeals]))
      this.updateComparisonDisplay()
      this.showToast(`Removed ${title} from comparison`, "info")
    })

    return item
  }

  toggleSaveDeal(button, dealName) {
    const icon = button.querySelector("i")
    const text = button.querySelector("span")

    if (button.classList.contains("saved")) {
      button.classList.remove("saved")
      icon.className = "far fa-heart"
      text.textContent = "Save Deal"
      this.showToast(`Removed ${dealName} from saved deals`, "info")
    } else {
      button.classList.add("saved")
      icon.className = "fas fa-heart"
      text.textContent = "Saved"
      this.showToast(`Saved ${dealName} deal!`, "success")
    }
  }

  // Enhanced Interaction Handlers
  handleQuickBook(destination) {
    this.showLoadingOverlay()

    setTimeout(() => {
      this.hideLoadingOverlay()
      this.showToast(`Quick booking for ${destination} - Redirecting...`, "success")
    }, 1500)
  }

  handleBookNow(destination) {
    this.showToast(`Booking ${destination} flight...`, "info")

    setTimeout(() => {
      this.showToast("Redirecting to secure booking page", "success")
    }, 1500)
  }

  exploreDestination(button) {
    const card = button.closest(".destination-card")
    const destination = card.querySelector("h3").textContent

    this.showToast(`Exploring deals for ${destination}...`, "info")

    setTimeout(() => {
      this.showToast(`Found 12 amazing deals for ${destination}!`, "success")
    }, 1500)
  }

  scrollToTop() {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    })

    this.showToast("Scrolled to top", "info")
  }

  handleSocialClick(e) {
    e.preventDefault()
    const platform = e.currentTarget.dataset.platform
    const messages = {
      facebook: "Opening Facebook page...",
      twitter: "Opening Twitter page...",
      instagram: "Opening Instagram page...",
      linkedin: "Opening LinkedIn page...",
    }

    this.showToast(messages[platform] || "Opening social media page...", "info")
  }

  handleScroll() {
    const backToTopBtn = document.getElementById("back-to-top-btn")
    if (backToTopBtn) {
      if (window.scrollY > 300) {
        backToTopBtn.style.opacity = "1"
        backToTopBtn.style.visibility = "visible"
      } else {
        backToTopBtn.style.opacity = "0"
        backToTopBtn.style.visibility = "hidden"
      }
    }
  }

  handleResize() {
    if (this.dealsSwiper) {
      this.dealsSwiper.update()
    }
  }

  // Toast Notifications
  showToast(message, type = "info") {
    const toastContainer = document.getElementById("toast-container") || this.createToastContainer()
    const toast = document.createElement("div")

    const icons = {
      success: "fas fa-check-circle",
      error: "fas fa-exclamation-circle",
      info: "fas fa-info-circle",
      warning: "fas fa-exclamation-triangle",
    }

    toast.className = `toast ${type}`
    toast.innerHTML = `
      <i class="${icons[type]}"></i>
      <span>${message}</span>
    `

    toastContainer.appendChild(toast)

    // Add entrance animation
    toast.style.transform = "translateX(100%)"
    toast.style.opacity = "0"

    setTimeout(() => {
      toast.style.transition = "all 0.4s ease"
      toast.style.transform = "translateX(0)"
      toast.style.opacity = "1"
    }, 10)

    // Auto remove after 4 seconds
    setTimeout(() => {
      if (toast.parentNode) {
        toast.style.transform = "translateX(100%)"
        toast.style.opacity = "0"

        setTimeout(() => {
          toast.remove()
        }, 400)
      }
    }, 4000)

    // Click to dismiss
    toast.addEventListener("click", () => {
      toast.style.transform = "translateX(100%)"
      toast.style.opacity = "0"
      setTimeout(() => toast.remove(), 400)
    })
  }

  createToastContainer() {
    const container = document.createElement("div")
    container.id = "toast-container"
    container.className = "toast-container"
    container.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 10px;
    `
    document.body.appendChild(container)
    return container
  }

  // Loading Overlay
  showLoadingOverlay() {
    const overlay = document.getElementById("loading-overlay")
    if (overlay) {
      overlay.classList.add("active")
    }
  }

  hideLoadingOverlay() {
    const overlay = document.getElementById("loading-overlay")
    if (overlay) {
      overlay.classList.remove("active")
    }
  }

  // Image Preloading
  preloadImages() {
    const images = [
      "../img/Dubai.jpg",
      "../img/paris.jpg",
      "../img/bangkok.jpg",
      "../img/Maldives.jpg",
      "../img/newlogo.png",
    ]

    images.forEach((src) => {
      const img = new Image()
      img.src = src
    })
  }
}

// Show all gallery destinations (keeping your original function)
function showAllDestinations() {
  const grid = document.querySelector(".gallery-grid")
  if (grid) {
    grid.classList.add("show-all")
    const viewAllBtn = document.querySelector(".view-all-button")
    if (viewAllBtn) {
      viewAllBtn.style.display = "none"
    }
  }
}

// Toggle Policy Sections (FIXED version)
function toggleSection(event, sectionId) {
  event.preventDefault()
  event.stopPropagation() // Prevent event bubbling

  const container = document.getElementById("policy-container")
  const privacy = document.getElementById("privacy-policy")
  const terms = document.getElementById("terms-of-service")

  // Hide both sections first
  privacy.style.display = "none"
  terms.style.display = "none"

  // Show the container and the selected section
  container.style.display = "block"
  container.classList.add("show")
  document.body.style.overflow = "hidden" // Prevent background scrolling

  if (sectionId === "privacy-policy") {
    privacy.style.display = "block"
  } else if (sectionId === "terms-of-service") {
    terms.style.display = "block"
  }

  // Add click outside to close functionality
  setTimeout(() => {
    container.addEventListener(
      "click",
      (e) => {
        if (e.target === container) {
          closePolicy()
        }
      },
      { once: true },
    )
  }, 100)
}

// Close Policy Container (FIXED version)
function closePolicy() {
  const container = document.getElementById("policy-container")
  const privacy = document.getElementById("privacy-policy")
  const terms = document.getElementById("terms-of-service")

  container.classList.remove("show")
  container.style.display = "none"
  privacy.style.display = "none"
  terms.style.display = "none"
  document.body.style.overflow = "auto" // Restore scrolling
}

// Initialize the enhanced website when DOM is ready
const enhancedEasyFlyWebsite = new EnhancedEasyFlyWebsite()

// Handle window resize
window.addEventListener("resize", () => {
  enhancedEasyFlyWebsite.handleResize()
})

// Export for global access if needed
window.EnhancedEasyFlyWebsite = enhancedEasyFlyWebsite

// Add CSS for animations
const style = document.createElement("style")
style.textContent = `
  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
  }

  .toast {
    min-width: 300px;
    padding: 15px 20px;
    border-radius: 8px;
    color: white;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    font-family: "Poppins", sans-serif;
    border-left: 4px solid rgba(255, 255, 255, 0.3);
    margin-bottom: 10px;
    cursor: pointer;
  }

  .toast.success {
    background: linear-gradient(135deg, #00b894, #00a085);
  }

  .toast.error {
    background: linear-gradient(135deg, #ff3b30, #e55656);
  }

  .toast.info {
    background: linear-gradient(135deg, #4046be, #5a67d8);
  }

  .toast.warning {
    background: linear-gradient(135deg, #ff9500, #e6850e);
  }

  .toast i {
    font-size: 1.2rem;
  }

  .swiper-slide.filtered-out {
    display: none !important;
  }

  .policy-card.show {
    display: block;
  }
`
document.head.appendChild(style)

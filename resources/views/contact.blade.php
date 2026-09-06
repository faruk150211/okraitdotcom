<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - OKRA IT</title>
    <link rel="icon" type="image/png" href="/images/favicon.png" />
    <!-- Bootstrap 5 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <style>
      body {
        font-family: "Segoe UI", sans-serif;
      }

      .topbar {
        background: #0d6efd;
        color: white;
        font-size: 14px;
      }

      .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0;
      }

      .service-card {
        transition: 0.3s;
        border-radius: 12px;
      }

      .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }

      .why-card {
        transition: 0.3s;
      }

      .why-card:hover {
        background: #f8f9fa;
        transform: scale(1.03);
      }

      .cta {
        background: #198754;
        color: white;
        padding: 60px 0;
      }

      footer {
        background: #212529;
        color: #ccc;
      }

      footer a {
        color: #ccc;
        text-decoration: none;
      }

      footer a:hover {
        color: white;
      }

      .navbar {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 60%) !important;
        border-bottom: none;
      }

      .navbar-brand,
      .nav-link {
        color: white !important;
      }

      .nav-link:hover {
        color: #f0f0f0 !important;
      }

      .contact-info-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .contact-info-card i {
        font-size: 32px;
        color: #0d6efd;
        margin-bottom: 15px;
      }

      .contact-info-card h5 {
        margin-bottom: 10px;
        color: #333;
      }

      .contact-info-card p {
        color: #666;
        margin: 0;
      }

      .form-control,
      .form-select {
        border: 1px solid #ddd;
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 14px;
      }

      .form-control:focus,
      .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
      }

      .form-label {
        color: #333;
        font-weight: 600;
        margin-bottom: 8px;
      }

      .btn-submit {
        background: #0d6efd;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        width: 100%;
        transition: 0.3s;
      }

      .btn-submit:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
      }

      .success-message {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
      }

      .success-message.show {
        display: block;
      }

      .required {
        color: #dc3545;
      }

      .contact-section {
        background: #f8f9fa;
        padding: 60px 0;
      }

      @media (max-width: 768px) {
        .hero {
          padding: 60px 0;
        }
      }

      /* WhatsApp Button Styles */
      .whatsapp-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: #25d366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
        z-index: 999;
        transition: all 0.3s ease;
        text-decoration: none;
      }

      .whatsapp-btn:hover {
        background: #20ba5a;
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
      }

      .whatsapp-btn i {
        color: white;
        font-size: 28px;
      }

      /* Wave Animation */
      .whatsapp-btn::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(37, 211, 102, 0.5);
        border-radius: 50%;
        animation: wave 2s infinite;
      }

      .whatsapp-btn::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(37, 211, 102, 0.3);
        border-radius: 50%;
        animation: wave 2s infinite 0.6s;
      }

      @keyframes wave {
        0% {
          transform: scale(1);
          opacity: 1;
        }
        100% {
          transform: scale(1.8);
          opacity: 0;
        }
      }

      .whatsapp-btn span {
        position: relative;
        z-index: 1;
      }

      @media (max-width: 768px) {
        .whatsapp-btn {
          bottom: 20px;
          right: 20px;
          width: 50px;
          height: 50px;
        }

        .whatsapp-btn i {
          font-size: 24px;
        }
      }
    </style>

    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
      <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/"
          ><img
            src="/images/logo.png"
            alt="OKRA IT Logo"
            width="150"
            height="60"
        /></a>

        <button
          class="navbar-toggler"
          data-bs-toggle="collapse"
          data-bs-target="#menu"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/portfolio">Portfolio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/training">Training</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact">Contact</a>
            </li>
            @if (Route::has('login'))
                @auth
                    <li class="nav-item">
                      <a class="nav-link text-warning fw-bold" href="/dashboard">Dashboard</a>
                    </li>
                @else
                    <li class="nav-item">
                      <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/register">Register</a>
                    </li>
                @endauth
            @endif
          </ul>
          <a href="/contact" class="btn btn-primary ms-3">Get Quote</a>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center" data-aos="fade-up">
      <div class="container">
        <h1 class="fw-bold" data-aos="fade-up">Get In Touch</h1>
        <p class="lead mt-3" data-aos="fade-up" data-aos-delay="200">
          We'd love to hear from you. Contact us today to discuss your project.
        </p>
      </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-section">
      <div class="container">
        <h2 class="fw-bold mb-5 text-center" data-aos="fade-up">
          Contact Information
        </h2>
        <div class="row">
          <div class="col-md-4" data-aos="fade-up">
            <div class="contact-info-card">
              <i class="bi bi-telephone"></i>
              <h5>Phone</h5>
              <p>+880-1401994575</p>
              <p>Available 9 AM - 6 PM (Sunday - Thursday)</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
            <div class="contact-info-card">
              <i class="bi bi-envelope"></i>
              <h5>Email</h5>
              <p>okrait@yahoo.com</p>
              <p>Response within 24 hours</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="contact-info-card">
              <i class="bi bi-geo-alt"></i>
              <h5>Office Address</h5>
              <p>Musolmanpara</p>
              <p>Khulna, Bangladesh</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Form & Map -->
    <section class="py-5">
      <div class="container">
        <div class="row">
          <!-- Contact Form -->
          <div class="col-md-6" data-aos="fade-up">
            <h3 class="fw-bold mb-4">Send us a Message</h3>

            <div class="success-message" id="successMessage">
              <i class="bi bi-check-circle me-2"></i>
              <strong>Success!</strong> Your message has been sent successfully.
              We'll get back to you soon.
            </div>

            <form id="contactForm">
              <div class="mb-4">
                <label for="name" class="form-label"
                  >Full Name <span class="required">*</span></label
                >
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  placeholder="John Doe"
                  required
                />
              </div>

              <div class="mb-4">
                <label for="email" class="form-label"
                  >Email Address <span class="required">*</span></label
                >
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="john@example.com"
                  required
                />
              </div>

              <div class="mb-4">
                <label for="phone" class="form-label">Phone Number</label>
                <input
                  type="tel"
                  class="form-control"
                  id="phone"
                  name="phone"
                  placeholder="+880-1401994575"
                />
              </div>

              <div class="mb-4">
                <label for="subject" class="form-label"
                  >Subject <span class="required">*</span></label
                >
                <select
                  class="form-select"
                  id="subject"
                  name="subject"
                  required
                >
                  <option value="">Select a subject...</option>
                  <option value="software-development">
                    Software Development
                  </option>
                  <option value="web-development">Web Development</option>
                  <option value="networking">Networking</option>
                  <option value="cctv">CCTV Installation</option>
                  <option value="training">Training Program</option>
                  <option value="general">General Inquiry</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div class="mb-4">
                <label for="message" class="form-label"
                  >Message <span class="required">*</span></label
                >
                <textarea
                  class="form-control"
                  id="message"
                  name="message"
                  rows="5"
                  placeholder="Tell us about your project..."
                  required
                ></textarea>
              </div>

              <button type="submit" class="btn btn-primary btn-submit">
                Send Message
              </button>
            </form>
          </div>

          <!-- Additional Info -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
            <h3 class="fw-bold mb-4">Quick Response</h3>

            <div class="bg-light p-4 rounded mb-4">
              <h6 class="fw-bold mb-3">Business Hours</h6>
              <p class="mb-2">
                <strong>Monday - Thursday:</strong> 9:00 AM - 6:00 PM
              </p>
              <p class="mb-2"><strong>Friday:</strong> 10:00 AM - 12:30 PM</p>
              <p class="mb-2"><strong>Saturday:</strong> 2:00 PM - 6:00 PM</p>
              <p><strong>Friday:</strong> Closed</p>
            </div>

            <div class="bg-light p-4 rounded mb-4">
              <h6 class="fw-bold mb-3">Services We Offer</h6>
              <ul class="list-unstyled">
                <li>
                  <i class="bi bi-check-circle text-success me-2"></i>Software
                  Development
                </li>
                <li>
                  <i class="bi bi-check-circle text-success me-2"></i>Web
                  Development
                </li>
                <li>
                  <i class="bi bi-check-circle text-success me-2"></i>Networking
                  Solutions
                </li>
                <li>
                  <i class="bi bi-check-circle text-success me-2"></i>CCTV
                  Installation
                </li>
                <li>
                  <i class="bi bi-check-circle text-success me-2"></i>DPP
                  Project Support
                </li>
                <li>
                  <i class="bi bi-check-circle text-success me-2"></i
                  >Professional Training
                </li>
              </ul>
            </div>

            <div class="bg-primary text-white p-4 rounded">
              <h6 class="fw-bold mb-2">Need Immediate Assistance?</h6>
              <p class="mb-3">
                Chat with us on WhatsApp for quick response and support.
              </p>
              <a
                href="https://wa.me/01712359608?text=Hello%20OKRA%20IT!%20I%20would%20like%20to%20inquire%20about%20your%20services."
                target="_blank"
                class="btn btn-light btn-sm"
              >
                <i class="bi bi-whatsapp me-2"></i>Message on WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-light py-5">
      <div class="container">
        <h2 class="fw-bold mb-5 text-center" data-aos="fade-up">
          Frequently Asked Questions
        </h2>

        <div class="accordion" id="faqAccordion">
          <div class="accordion-item" data-aos="fade-up">
            <h2 class="accordion-header">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#faq1"
              >
                How long does a typical project take?
              </button>
            </h2>
            <div
              id="faq1"
              class="accordion-collapse collapse show"
              data-bs-parent="#faqAccordion"
            >
              <div class="accordion-body">
                Project timelines vary based on scope and complexity. Simple web
                projects take 2-4 weeks, while enterprise solutions may take 2-6
                months. We provide detailed timelines after initial
                consultation.
              </div>
            </div>
          </div>

          <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#faq2"
              >
                Do you provide post-project support?
              </button>
            </h2>
            <div
              id="faq2"
              class="accordion-collapse collapse"
              data-bs-parent="#faqAccordion"
            >
              <div class="accordion-body">
                Yes, we provide comprehensive support packages including
                maintenance, updates, and bug fixes. Packages can be customized
                based on your needs.
              </div>
            </div>
          </div>

          <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#faq3"
              >
                What payment options do you accept?
              </button>
            </h2>
            <div
              id="faq3"
              class="accordion-collapse collapse"
              data-bs-parent="#faqAccordion"
            >
              <div class="accordion-body">
                We accept bank transfers, online payments, and flexible payment
                plans. For large projects, we typically work with 50% upfront
                and 50% upon completion.
              </div>
            </div>
          </div>

          <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
            <h2 class="accordion-header">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#faq4"
              >
                Can you work with my existing team?
              </button>
            </h2>
            <div
              id="faq4"
              class="accordion-collapse collapse"
              data-bs-parent="#faqAccordion"
            >
              <div class="accordion-body">
                Absolutely! We're experienced in collaborating with in-house
                teams and other vendors. We can integrate seamlessly into your
                existing workflow.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta text-center" data-aos="fade-up">
      <div class="container">
        <h2>Still Have Questions?</h2>
        <p class="mt-3">
          Our team is here to help. Don't hesitate to reach out!
        </p>
        <a href="#contactForm" class="btn btn-light btn-lg mt-3">Contact Us</a>
      </div>
    </section>

    <!-- Footer -->
    <footer class="pt-5 pb-3" data-aos="fade-up">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <img
              src="/images/logo.png"
              alt="OKRA IT Logo"
              width="100"
              height="40"
              class="mb-3"
            />
            <p>Your trusted IT service provider for modern solutions.</p>
          </div>

          <div class="col-md-4">
            <h5>Services</h5>
            <ul class="list-unstyled">
              <li><a href="/services">Software Development</a></li>
              <li><a href="/services">Web Development</a></li>
              <li><a href="/services">Networking & CCTV</a></li>
              <li><a href="/training">Training Programs</a></li>
            </ul>
          </div>

          <div class="col-md-4">
            <h5>Contact</h5>
            <p>Email: okrait@yahoo.com</p>
            <p>Phone: +880-1401-994575</p>
          </div>
        </div>

        <hr />
        <div class="text-center">
          <p>© 2026 OKRA IT. All Rights Reserved.</p>
        </div>
      </div>
    </footer>

    <!-- WhatsApp Button -->
    <a
      href="https://wa.me/01712359608?text=Hello%20OKRA%20IT!%20I%20would%20like%20to%20inquire%20about%20your%20services."
      target="_blank"
      class="whatsapp-btn"
      title="Chat on WhatsApp"
    >
      <span><i class="bi bi-whatsapp"></i></span>
    </a>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
      AOS.init({
        duration: 1000,
        once: true,
      });

      // Contact Form Handler
      const contactForm = document.getElementById("contactForm");
      const successMessage = document.getElementById("successMessage");

      if (contactForm) {
        contactForm.addEventListener("submit", function (e) {
          e.preventDefault();

          // Show success message
          successMessage.classList.add("show");

          // Reset form
          contactForm.reset();

          // Hide success message after 5 seconds
          setTimeout(() => {
            successMessage.classList.remove("show");
          }, 5000);
        });
      }
    </script>
  </body>
</html>



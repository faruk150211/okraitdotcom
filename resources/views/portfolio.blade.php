<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Our Portfolio - OKRA IT</title>
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

      .portfolio-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
      }

      .portfolio-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: 0.3s;
      }

      .portfolio-item:hover img {
        transform: scale(1.05);
      }

      .portfolio-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 20px;
        color: white;
        opacity: 0;
        transition: 0.3s;
      }

      .portfolio-item:hover .portfolio-overlay {
        opacity: 1;
      }

      .portfolio-overlay h5 {
        margin-bottom: 10px;
      }

      .tags {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
      }

      .tag {
        background: #0d6efd;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
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
        <h1 class="fw-bold" data-aos="fade-up">Our Portfolio</h1>
        <p class="lead mt-3" data-aos="fade-up" data-aos-delay="200">
          Showcasing Our Latest Projects & Success Stories
        </p>
      </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="py-5">
      <div class="container">
        <div class="row g-4">
          <div class="col-md-4" data-aos="zoom-in">
            <div class="portfolio-item service-card">
              <img src="/images/ecom.png" alt="E-Commerce Platform" />
              <div class="portfolio-overlay">
                <h5>E-Commerce Platform</h5>
                <p>
                  Custom web platform for online retail with payment integration
                </p>
                <div class="tags">
                  <span class="tag">Web Development</span>
                  <span class="tag">E-Commerce</span>
                </div>
              </div>
            </div>
            <div class="p-3 bg-white text-center">
              <h6>E-Commerce Platform</h6>
              <p class="text-muted small">Online Retail Solution</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="150">
            <div class="portfolio-item service-card">
              <img src="/images/hms.png" alt="Hospital Management System" />
              <div class="portfolio-overlay">
                <h5>Hospital Management System</h5>
                <p>
                  Complete healthcare management system with patient records
                </p>
                <div class="tags">
                  <span class="tag">Software Dev</span>
                  <span class="tag">Healthcare</span>
                </div>
              </div>
            </div>
            <div class="p-3 bg-white text-center">
              <h6>Hospital Management System</h6>
              <p class="text-muted small">Healthcare Solution</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="portfolio-item service-card">
              <img src="/images/switch.jpg" alt="Industrial Network Setup" />
              <div class="portfolio-overlay">
                <h5>Industrial Network Setup</h5>
                <p>
                  Enterprise-level networking infrastructure for financial
                  institution
                </p>
                <div class="tags">
                  <span class="tag">Networking</span>
                  <span class="tag">Enterprise</span>
                </div>
              </div>
            </div>
            <div class="p-3 bg-white text-center">
              <h6>Industrial Network Setup</h6>
              <p class="text-muted small">Enterprise Networking</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="portfolio-item service-card">
              <img src="/images/camera.png" alt="Corporate Security System" />
              <div class="portfolio-overlay">
                <h5>Corporate Security System</h5>
                <p>CCTV and access control system for corporate headquarters</p>
                <div class="tags">
                  <span class="tag">CCTV</span>
                  <span class="tag">Security</span>
                </div>
              </div>
            </div>
            <div class="p-3 bg-white text-center">
              <h6>Corporate Security System</h6>
              <p class="text-muted small">Security Infrastructure</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="portfolio-item service-card">
              <img
                src="/images/dashboard.png"
                alt="Business Analytics Dashboard"
              />
              <div class="portfolio-overlay">
                <h5>Business Analytics Dashboard</h5>
                <p>
                  Real-time analytics and reporting tool for data-driven
                  decisions
                </p>
                <div class="tags">
                  <span class="tag">Analytics</span>
                  <span class="tag">Dashboard</span>
                </div>
              </div>
            </div>
            <div class="p-3 bg-white text-center">
              <h6>Business Analytics Dashboard</h6>
              <p class="text-muted small">Data Analytics Solution</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="portfolio-item service-card">
              <img src="/images/education.jpg" alt="Educational Platform" />
              <div class="portfolio-overlay">
                <h5>Educational Platform</h5>
                <p>Online learning management system with student tracking</p>
                <div class="tags">
                  <span class="tag">Web Dev</span>
                  <span class="tag">Education</span>
                </div>
              </div>
            </div>
            <div class="p-3 bg-white text-center">
              <h6>Educational Platform</h6>
              <p class="text-muted small">E-Learning Solution</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Portfolio Stats -->
    <section class="bg-light py-5">
      <div class="container text-center">
        <h2 class="fw-bold mb-5" data-aos="fade-up">
          Why Our Clients Choose Us
        </h2>
        <div class="row g-4">
          <div class="col-md-4" data-aos="fade-up">
            <div class="p-4">
              <i class="bi bi-file-earmark-check fs-1 text-primary mb-3"></i>
              <h3>50+</h3>
              <p>Projects Completed</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
            <div class="p-4">
              <i class="bi bi-people fs-1 text-success mb-3"></i>
              <h3>30+</h3>
              <p>Happy Clients</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="p-4">
              <i class="bi bi-award fs-1 text-warning mb-3"></i>
              <h3>10+</h3>
              <p>Years Experience</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta text-center" data-aos="fade-up">
      <div class="container">
        <h2>Interested in Working With Us?</h2>
        <p class="mt-3">Let's bring your next project to life</p>
        <a href="/contact" class="btn btn-light btn-lg mt-3"
          >Start Your Project</a
        >
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
              <li><a href="/services">CCTV & Networking</a></li>
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
    </script>
  </body>
</html>



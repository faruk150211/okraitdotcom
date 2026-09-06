<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Our Services - OKRA IT</title>
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

      .service-detail {
        background: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
      }

      .service-detail h3 {
        color: #0d6efd;
        margin-bottom: 15px;
      }

      .service-detail p {
        color: #666;
        line-height: 1.8;
      }

      .service-list {
        list-style: none;
        padding: 0;
      }

      .service-list li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        color: #555;
      }

      .service-list li:before {
        content: "✓ ";
        color: #198754;
        font-weight: bold;
        margin-right: 10px;
      }

      .service-list li:last-child {
        border-bottom: none;
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
        <h1 class="fw-bold" data-aos="fade-up">Our Services</h1>
        <p class="lead mt-3" data-aos="fade-up" data-aos-delay="200">
          Comprehensive IT Solutions for Your Business
        </p>
      </div>
    </section>

    <!-- Services -->
    <section class="bg-light py-5">
      <div class="container text-center">
        <div class="row mb-4">
          <div class="col-12">
            <div
              class="d-flex justify-content-center align-items-center position-relative"
            >
              <h2 class="fw-bold mb-0">Our Services</h2>
            </div>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-md-4" data-aos="zoom-in">
            <div class="p-4 bg-white service-card h-100">
              <i class="bi bi-code-slash fs-1 text-primary"></i>
              <h5 class="mt-3">Software Development</h5>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="p-4 bg-white service-card h-100">
              <i class="bi bi-diagram-3 fs-1 text-warning"></i>
              <h5 class="mt-3">Networking</h5>
            </div>
          </div>

          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="p-4 bg-white service-card h-100">
              <i class="bi bi-camera-video fs-1 text-danger"></i>
              <h5 class="mt-3">Security Surveillance System</h5>
            </div>
          </div>

          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="150">
            <div class="p-4 bg-white service-card h-100">
              <i class="bi bi-globe fs-1 text-success"></i>
              <h5 class="mt-3">Training</h5>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="p-4 bg-white service-card h-100">
              <i class="bi bi-file-earmark-text fs-1 text-info"></i>
              <h5 class="mt-3">Proposal Writing Support</h5>
            </div>
          </div>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="p-4 bg-white service-card h-100">
              <i class="bi bi-sun fs-1 text-warning"></i>
              <h5 class="mt-3">Solar Power & Renewable Energy Solutions</h5>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Service Details -->
    <section class="py-5">
      <div class="container">
        <h2 class="fw-bold mb-5 text-center" data-aos="fade-up">
          Service Details
        </h2>

        <div class="row">
          <div class="col-md-6" data-aos="fade-up">
            <div class="service-detail">
              <i class="bi bi-code-slash fs-2 text-primary mb-3"></i>
              <h3>Software Development</h3>
              <p>
                We create custom software solutions that streamline your
                business operations and enhance productivity.
              </p>
              <ul class="service-list">
                <li>Desktop Applications</li>
                <li>Mobile Applications</li>
                <li>Cloud Solutions</li>
                <li>Integration Services</li>
                <li>Maintenance & Support</li>
              </ul>
            </div>
          </div>
          
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-detail">
              <i class="bi bi-diagram-3 fs-2 text-warning mb-3"></i>
              <h3>Networking</h3>
              <p>
                Enterprise networking infrastructure designed for reliability
                and performance.
              </p>
              <ul class="service-list">
                <li>Network Design & Setup</li>
                <li>Firewall Configuration</li>
                <li>VPN Setup</li>
                <li>Network Security</li>
                <li>Troubleshooting & Maintenance</li>
              </ul>
            </div>
          </div>

          <!--<div class="col-md-6" data-aos="fade-up" data-aos-delay="100">-->
          <!--  <div class="service-detail">-->
          <!--    <i class="bi bi-globe fs-2 text-success mb-3"></i>-->
          <!--    <h3>Web Development</h3>-->
          <!--    <p>-->
          <!--      Modern, responsive websites optimized for all devices and search-->
          <!--      engines.-->
          <!--    </p>-->
          <!--    <ul class="service-list">-->
          <!--      <li>Responsive Design</li>-->
          <!--      <li>E-Commerce Platforms</li>-->
          <!--      <li>Content Management Systems</li>-->
          <!--      <li>SEO Optimization</li>-->
          <!--      <li>Performance Tuning</li>-->
          <!--    </ul>-->
          <!--  </div>-->
          <!--</div>-->

          <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-detail">
              <i class="bi bi-camera-video fs-2 text-danger mb-3"></i>
              <h3>Security Surveillance System</h3>
              <p>
                Professional surveillance system installation and maintenance
                for comprehensive security.
              </p>
              <ul class="service-list">
                <li>HD & 4K Cameras</li>
                <li>NVR/DVR Systems</li>
                <li>Remote Monitoring</li>
                <li>Cloud Storage</li>
                <li>24/7 Support</li>
              </ul>
            </div>
          </div>
          
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
            <div class="service-detail">
              <i class="bi bi-book fs-2 text-success mb-3"></i>
              <h3>Training</h3>
              <p>
                Comprehensive professional training programs designed to enhance
                skills and expertise in various IT domains.
              </p>
              <ul class="service-list">
                <li>Software Development Training</li>
                <li>Network Administration & Security</li>
                <li>CCTV & Surveillance Systems</li>
                <li>IT Certifications & Courses</li>
                <li>Corporate Training Programs</li>
              </ul>
            </div>
          </div>

          <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-detail">
              <i class="bi bi-file-earmark-text fs-2 text-info mb-3"></i>
              <h3>Proposal Writing Support</h3>
              <p>
                Comprehensive development project proposals for innovative
                software solutions.
              </p>
              <ul class="service-list">
                <li>Project Requirement Analysis & Planning</li>
                <li>Scope of Work & Module Breakdown</li>
                <li>Technology Stack & System Architecture</li>
                <li>Timeline & Milestone Planning</li>
                <li>Budget Estimation & Cost Breakdown</li>
                <li>Risk Analysis & Mitigation Strategy</li>
                
              </ul>
            </div>
          </div>

          <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-detail">
              <i class="bi bi-sun fs-1 text-warning"></i>
              <h3>Solar Power & Renewable Energy Solutions</h3>
              <p>
                Comprehensive solar energy systems providing clean, renewable
                power solutions for residential and commercial applications.
              </p>
              <ul class="service-list">
                <li>Solar Panel Installation</li>
                <li>System Design & Consultation</li>
                <li>Inverter & Battery Solutions</li>
                <li>Grid Integration & Monitoring</li>
                <li>Maintenance & Support</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- DPP Related Features -->
    <!-- <section class="py-5 bg-light">
      <div class="container">
        <h2 class="fw-bold mb-5 text-center" data-aos="fade-up">
          DPP Implementation Process
        </h2>

        <div class="row g-4">
          <div class="col-md-4" data-aos="fade-up">
            <div class="p-4 bg-white service-card">
              <div
                class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-sketch fs-3 text-info"></i>
              </div>
              <h5 class="mt-3">Requirements Analysis</h5>
              <p class="text-muted">
                In-depth consultation to understand your project goals, scope,
                and technical requirements.
              </p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="p-4 bg-white service-card">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-pencil-square fs-3 text-primary"></i>
              </div>
              <h5 class="mt-3">Proposal Development</h5>
              <p class="text-muted">
                Detailed proposal document with timeline, budget, deliverables,
                and resource allocation.
              </p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="p-4 bg-white service-card">
              <div
                class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-check-circle fs-3 text-success"></i>
              </div>
              <h5 class="mt-3">Approval & Planning</h5>
              <p class="text-muted">
                Stakeholder approval, team assignment, and project milestone
                planning.
              </p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="p-4 bg-white service-card">
              <div
                class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-gear fs-3 text-warning"></i>
              </div>
              <h5 class="mt-3">Development Execution</h5>
              <p class="text-muted">
                Agile development process with regular updates, sprint reviews,
                and quality assurance.
              </p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="p-4 bg-white service-card">
              <div
                class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-bug fs-3 text-danger"></i>
              </div>
              <h5 class="mt-3">Testing & QA</h5>
              <p class="text-muted">
                Comprehensive testing, bug fixing, performance optimization, and
                security validation.
              </p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="p-4 bg-white service-card">
              <div
                class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-rocket fs-3 text-secondary"></i>
              </div>
              <h5 class="mt-3">Deployment & Support</h5>
              <p class="text-muted">
                Production deployment, user training, documentation, and ongoing
                technical support.
              </p>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-12" data-aos="fade-up">
            <div class="p-4 bg-white rounded-3 border">
              <h4 class="mb-4">
                <i class="bi bi-star-fill text-warning"></i> Key DPP Features
              </h4>
              <div class="row">
                <div class="col-md-6">
                  <ul class="service-list">
                    <li>Customizable Project Scope</li>
                    <li>Flexible Budget Options</li>
                    <li>Clear Milestone Tracking</li>
                    <li>Risk Assessment & Mitigation</li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="service-list">
                    <li>Resource & Team Planning</li>
                    <li>Communication Framework</li>
                    <li>Quality Assurance Standards</li>
                    <li>Post-Launch Support</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    <!-- CTA -->
    <section class="cta text-center" data-aos="fade-up">
      <div class="container">
        <h2>Ready to Get Started?</h2>
        <p class="mt-3">
          Let's discuss how our services can help your business
        </p>
        <a href="/contact" class="btn btn-light btn-lg mt-3"
          >Contact Us Today</a
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
              <li><a href="/services#software">Software Development</a></li>
              <li><a href="/services#web">Web Development</a></li>
              <li><a href="/services#cctv">CCTV</a></li>
              <li><a href="/services#networking">Networking</a></li>
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



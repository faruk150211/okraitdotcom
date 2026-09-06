<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OKRA IT - IT Service Agency</title>
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
    <!-- Topbar -->
    <!-- <div class="topbar py-2">
      <div class="container d-flex justify-content-between">
        <div>Email: info@okrait.com | Phone: +880-123456789</div>
        <div>
          <i class="bi bi-facebook me-2"></i>
          <i class="bi bi-linkedin"></i>
        </div>
      </div>
    </div> -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
      <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#"
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

    <!-- Hero -->
    <section class="hero text-center" data-aos="fade-up">
      <div class="container">
        <h1 class="fw-bold" data-aos="fade-up">
          Smart IT Solutions for Modern Business
        </h1>
        <p class="lead mt-3" data-aos="fade-up" data-aos-delay="200">
          Software, Networking, CCTV, DPP & Complete IT Services
        </p>
        <a
          href="/services"
          class="btn btn-light btn-lg mt-3"
          data-aos="zoom-in"
          data-aos-delay="400"
          >Explore Services</a
        >
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5">
      <div class="container text-center">
        <h2 class="fw-bold mb-4">Why Choose Us</h2>
        <div class="row g-4">
          <div class="col-md-4" data-aos="fade-up">
            <div class="p-4 border rounded why-card h-100">
              <i class="bi bi-lightning-charge fs-1 text-primary"></i>
              <h5 class="mt-3">Fast Delivery</h5>
              <p>Quick and efficient service delivery for all IT solutions.</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="p-4 border rounded why-card h-100">
              <i class="bi bi-shield-check fs-1 text-success"></i>
              <h5 class="mt-3">Reliable</h5>
              <p>Trusted by clients for quality and long-term support.</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="p-4 border rounded why-card h-100">
              <i class="bi bi-people fs-1 text-danger"></i>
              <h5 class="mt-3">Expert Team</h5>
              <p>Skilled professionals delivering top-notch services.</p>
            </div>
          </div>
        </div>
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
              <a
                href="/services"
                class="btn btn-outline-primary btn-sm position-absolute end-0"
                >See All →</a
              >
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

    <!-- How it Works -->
    <section class="bg-light py-5">
      <div class="container text-center">
        <h2 class="fw-bold mb-4">How It Works</h2>

        <div class="row g-4">
          <div class="col-md-6 col-lg-3" data-aos="zoom-in">
            <div
              class="p-4 bg-white service-card rounded h-100 d-flex flex-column align-items-center"
            >
              <div
                class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-chat-dots fs-4"></i>
              </div>
              <h5 class="mt-3 fw-bold">1. Consultation</h5>
              <p class="mt-2 flex-grow-1">
                Understand your business needs and project requirements in
                detail.
              </p>
            </div>
          </div>

          <div
            class="col-md-6 col-lg-3"
            data-aos="zoom-in"
            data-aos-delay="150"
          >
            <div
              class="p-4 bg-white service-card rounded h-100 d-flex flex-column align-items-center"
            >
              <div
                class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-diagram-3 fs-4"></i>
              </div>
              <h5 class="mt-3 fw-bold">2. Planning</h5>
              <p class="mt-2 flex-grow-1">
                Create a comprehensive project roadmap and timeline strategy.
              </p>
            </div>
          </div>

          <div
            class="col-md-6 col-lg-3"
            data-aos="zoom-in"
            data-aos-delay="300"
          >
            <div
              class="p-4 bg-white service-card rounded h-100 d-flex flex-column align-items-center"
            >
              <div
                class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-gear fs-4"></i>
              </div>
              <h5 class="mt-3 fw-bold">3. Execution</h5>
              <p class="mt-2 flex-grow-1">
                Develop and implement your solution with expert precision.
              </p>
            </div>
          </div>

          <div
            class="col-md-6 col-lg-3"
            data-aos="zoom-in"
            data-aos-delay="450"
          >
            <div
              class="p-4 bg-white service-card rounded h-100 d-flex flex-column align-items-center"
            >
              <div
                class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <i class="bi bi-check-circle fs-4"></i>
              </div>
              <h5 class="mt-3 fw-bold">4. Delivery</h5>
              <p class="mt-2 flex-grow-1">
                Deploy your solution and provide ongoing support and
                maintenance.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Portfolio -->
    <section class="py-5">
      <div class="container">
        <div class="row mb-4">
          <div class="col-12">
            <div
              class="d-flex justify-content-center align-items-center position-relative"
            >
              <h2 class="fw-bold mb-0">Our Portfolio</h2>
              <a
                href="/portfolio"
                class="btn btn-outline-primary btn-sm position-absolute end-0"
                >See All →</a
              >
            </div>
          </div>
        </div>
        <div class="row g-4 text-center">
          <div class="col-md-4" data-aos="zoom-in">
            <div class="service-card overflow-hidden">
              <img
                src="/images/ecom.png"
                alt="E-Commerce Platform"
                class="w-100"
                style="object-fit: cover"
              />
              <div class="p-4 bg-white">
                <h5 class="mt-3">E-Commerce Platform</h5>
                <p>
                  Custom web platform for online retail with payment integration
                </p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
              </div>
            </div>
          </div>

          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="150">
            <div class="service-card overflow-hidden">
              <img
                src="/images/hms.png"
                alt="Hospital Management System"
                class="w-100"
                style="object-fit: cover"
              />
              <div class="p-4 bg-white">
                <h5 class="mt-3">Hospital Management System</h5>
                <p>
                  Complete healthcare management system with patient records
                </p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
              </div>
            </div>
          </div>

          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="service-card overflow-hidden">
              <img
                src="/images/switch.jpg"
                alt="Industrial Network Setup"
                class="w-100"
                style="height: 220px; object-fit: cover"
              />
              <div class="p-4 bg-white">
                <h5 class="mt-3">Industrial Network Setup</h5>
                <p>
                  Enterprise-level networking infrastructure for financial
                  institution
                </p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
              </div>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="service-card overflow-hidden">
              <img
                src="/images/camera.png"
                alt="Security Surveillance System"
                class="w-100"
                style="object-fit: cover"
              />
              <div class="p-4 bg-white">
                <h5 class="mt-3">Security Surveillance System</h5>
                <p>CCTV and access control system for corporate headquarters</p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
              </div>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="service-card overflow-hidden">
              <img
                src="/images/dashboard.png"
                alt="Business Analytics Dashboard"
                class="w-100"
                style="object-fit: cover"
              />
              <div class="p-4 bg-white">
                <h5 class="mt-3">Business Analytics Dashboard</h5>
                <p>
                  Real-time analytics and reporting tool for data-driven
                  decisions
                </p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
              </div>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="service-card overflow-hidden">
              <img
                src="/images/education.jpg"
                alt="Educational Platform"
                class="w-100"
                style="object-fit: cover"
              />
              <div class="p-4 bg-white">
                <h5 class="mt-3">Educational Platform</h5>
                <p>Online learning management system with student tracking</p>
                <a href="#" class="btn btn-primary btn-sm">Learn More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <!--<section class="py-5 bg-light">-->
    <!--  <div class="container">-->
    <!--    <h2 class="fw-bold mb-5 text-center">What Our Clients Say</h2>-->
    <!--    <div class="row g-4">-->
    <!--      <div class="col-md-4" data-aos="fade-up">-->
    <!--        <div class="p-4 bg-white service-card rounded">-->
    <!--          <div class="mb-3">-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--          </div>-->
    <!--          <p class="mb-4">-->
    <!--            "OKRA IT delivered exceptional results for our e-commerce-->
    <!--            platform. Their team was professional, responsive, and delivered-->
    <!--            ahead of schedule."-->
    <!--          </p>-->
    <!--          <div class="d-flex align-items-center">-->
    <!--            <div-->
    <!--              class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"-->
    <!--              style="width: 45px; height: 45px"-->
    <!--            >-->
    <!--              <i class="bi bi-person fs-5"></i>-->
    <!--            </div>-->
    <!--            <div class="ms-3">-->
    <!--              <h6 class="mb-0">John Ahmed</h6>-->
    <!--              <small class="text-muted">CEO, Tech Solutions Ltd</small>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">-->
    <!--        <div class="p-4 bg-white service-card rounded">-->
    <!--          <div class="mb-3">-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--          </div>-->
    <!--          <p class="mb-4">-->
    <!--            "The networking infrastructure setup was flawless. We've had-->
    <!--            zero downtime since implementation. Highly recommend their-->
    <!--            services!"-->
    <!--          </p>-->
    <!--          <div class="d-flex align-items-center">-->
    <!--            <div-->
    <!--              class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"-->
    <!--              style="width: 45px; height: 45px"-->
    <!--            >-->
    <!--              <i class="bi bi-person fs-5"></i>-->
    <!--            </div>-->
    <!--            <div class="ms-3">-->
    <!--              <h6 class="mb-0">Sarah Khan</h6>-->
    <!--              <small class="text-muted"-->
    <!--                >Operations Manager, Global Bank</small-->
    <!--              >-->
    <!--            </div>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->

    <!--      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">-->
    <!--        <div class="p-4 bg-white service-card rounded">-->
    <!--          <div class="mb-3">-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--            <i class="bi bi-star-fill text-warning"></i>-->
    <!--          </div>-->
    <!--          <p class="mb-4">-->
    <!--            "CCTV installation was comprehensive and professional. The-->
    <!--            support team is always ready to help. Best investment for our-->
    <!--            facility!"-->
    <!--          </p>-->
    <!--          <div class="d-flex align-items-center">-->
    <!--            <div-->
    <!--              class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"-->
    <!--              style="width: 45px; height: 45px"-->
    <!--            >-->
    <!--              <i class="bi bi-person fs-5"></i>-->
    <!--            </div>-->
    <!--            <div class="ms-3">-->
    <!--              <h6 class="mb-0">Michael Hassan</h6>-->
    <!--              <small class="text-muted"-->
    <!--                >Facility Director, Healthcare Plus</small-->
    <!--              >-->
    <!--            </div>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</section>-->

    <!-- CTA -->
    <section class="cta text-center" data-aos="fade-up">
      <div class="container">
        <h2>Ready to Start Your Project?</h2>
        <p class="mt-3">Contact us today for professional IT solutions</p>
        <a href="/contact" class="btn btn-light btn-lg mt-3">Get Started</a>
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
              <li><a href="/services">Networking</a></li>
              <li><a href="/services">CCTV</a></li>
              <li><a href="/training">Training</a></li>
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
        duration: 1000, // animation speed
        once: true, // animate only once
      });
    </script>
  </body>
</html>



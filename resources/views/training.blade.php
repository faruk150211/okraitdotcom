<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Training Programs - OKRA IT</title>
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

      .course-card {
        border: 2px solid #f0f0f0;
        padding: 30px;
        border-radius: 12px;
        background: white;
        transition: 0.3s;
      }

      .course-card:hover {
        border-color: #0d6efd;
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.2);
        transform: translateY(-5px);
      }

      .course-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
        border-radius: 8px;
        color: white;
        margin-bottom: 20px;
      }

      .course-duration {
        display: inline-block;
        background: #e7f1ff;
        color: #0d6efd;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 10px;
      }

      .course-level {
        display: inline-block;
        background: #d4edda;
        color: #198754;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        margin-bottom: 10px;
        margin-left: 10px;
      }

      .course-topics {
        list-style: none;
        padding: 0;
      }

      .course-topics li {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        color: #666;
      }

      .course-topics li:before {
        content: "✓ ";
        color: #198754;
        font-weight: bold;
        margin-right: 10px;
      }

      .course-topics li:last-child {
        border-bottom: none;
      }

      .pricing {
        font-size: 28px;
        color: #0d6efd;
        font-weight: bold;
        margin: 20px 0;
      }

      .enroll-btn {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
      }

      .testimonial-card {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 12px;
        border-left: 4px solid #0d6efd;
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
        <h1 class="fw-bold" data-aos="fade-up">
          Professional Training Programs
        </h1>
        <p class="lead mt-3" data-aos="fade-up" data-aos-delay="200">
          Enhance Your Skills with Our Expert-Led Courses
        </p>
      </div>
    </section>

    <!-- Why Our Training -->
    <section class="bg-light py-5">
      <div class="container text-center">
        <h2 class="fw-bold mb-4" data-aos="fade-up">
          Why Choose Our Training?
        </h2>
        <div class="row g-4">
          <div class="col-md-4" data-aos="fade-up">
            <div class="p-4 border rounded why-card h-100">
              <i class="bi bi-star-fill fs-1 text-primary"></i>
              <h5 class="mt-3">Expert Instructors</h5>
              <p>Learn from industry experts with 10+ years of experience</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="p-4 border rounded why-card h-100">
              <i class="bi bi-diagram-2 fs-1 text-success"></i>
              <h5 class="mt-3">Hands-On Learning</h5>
              <p>Practical projects and real-world scenarios included</p>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="p-4 border rounded why-card h-100">
              <i class="bi bi-award fs-1 text-danger"></i>
              <h5 class="mt-3">Certification</h5>
              <p>Recognized certificates upon successful completion</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Training Programs -->
    <section class="py-5">
      <div class="container">
        <h2 class="fw-bold mb-5 text-center" data-aos="fade-up">
          We Offer a Variety of Training Programs to Suit Your Needs
        </h2>

        <div class="row g-4">
          <!-- Course 1 -->
          <div class="col-md-6" data-aos="fade-up">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Web Development Bootcamp</h4>
              </div>
              <div>
                <span class="course-duration">12 Weeks</span>
                <span class="course-level">Beginner to Intermediate</span>
              </div>
              <p class="mt-3">
                Master full-stack web development with the latest technologies
                and frameworks.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>HTML5 & CSS3 Fundamentals</li>
                <li>JavaScript & ES6+</li>
                <li>React Framework</li>
                <li>Node.js & Express</li>
                <li>Database Design & SQL</li>
                <li>Project Development</li>
              </ul>
            </div>
          </div>

          <!-- Course 2 -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Network Administration</h4>
              </div>
              <div>
                <span class="course-duration">8 Weeks</span>
                <span class="course-level">Intermediate</span>
              </div>
              <p class="mt-3">
                Comprehensive networking fundamentals, configuration, and
                enterprise solutions.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>Networking Basics & OSI Model</li>
                <li>Cisco Networking</li>
                <li>TCP/IP Protocol Suite</li>
                <li>Firewalls & Security</li>
                <li>VPN Configuration</li>
                <li>Network Troubleshooting</li>
              </ul>
            </div>
          </div>

          <!-- Course 3 -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Cybersecurity Fundamentals</h4>
              </div>
              <div>
                <span class="course-duration">10 Weeks</span>
                <span class="course-level">Beginner to Advanced</span>
              </div>
              <p class="mt-3">
                Learn to protect systems and networks from cyber threats and
                attacks.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>Security Principles</li>
                <li>Cryptography & Encryption</li>
                <li>Threat Analysis & Mitigation</li>
                <li>Penetration Testing</li>
                <li>Compliance & Standards</li>
                <li>Incident Response</li>
              </ul>
            </div>
          </div>

          <!-- Course 4 -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="450">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Software Development with Python</h4>
              </div>
              <div>
                <span class="course-duration">10 Weeks</span>
                <span class="course-level">Beginner to Intermediate</span>
              </div>
              <p class="mt-3">
                Build powerful applications using Python programming language.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>Python Fundamentals</li>
                <li>Object-Oriented Programming</li>
                <li>Django Framework</li>
                <li>Database Integration</li>
                <li>API Development</li>
                <li>Deployment & DevOps</li>
              </ul>
            </div>
          </div>

          <!-- Course 5 -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Mobile App Development</h4>
              </div>
              <div>
                <span class="course-duration">12 Weeks</span>
                <span class="course-level">Intermediate</span>
              </div>
              <p class="mt-3">
                Develop native and cross-platform mobile applications for iOS &
                Android.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>Android Development</li>
                <li>iOS Development</li>
                <li>React Native</li>
                <li>Mobile UI/UX Design</li>
                <li>App Publishing</li>
                <li>User Analytics</li>
              </ul>
            </div>
          </div>

          <!-- Course 6 -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="750">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Cloud Infrastructure & DevOps</h4>
              </div>
              <div>
                <span class="course-duration">8 Weeks</span>
                <span class="course-level">Advanced</span>
              </div>
              <p class="mt-3">
                Master cloud platforms, containerization, and DevOps practices.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>AWS & Cloud Platforms</li>
                <li>Docker Containers</li>
                <li>Kubernetes Orchestration</li>
                <li>CI/CD Pipelines</li>
                <li>Infrastructure as Code</li>
                <li>Monitoring & Logging</li>
              </ul>
            </div>
          </div>

          <!-- Course 7 -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="900">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Nuxt.js Advanced Development</h4>
              </div>
              <div>
                <span class="course-duration">10 Weeks</span>
                <span class="course-level">Intermediate to Advanced</span>
              </div>
              <p class="mt-3">
                Build powerful server-side rendered and static Vue.js
                applications with Nuxt.js framework.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>Nuxt.js Fundamentals</li>
                <li>Server-Side Rendering (SSR)</li>
                <li>Static Site Generation</li>
                <li>API Routes & Middleware</li>
                <li>SEO Optimization</li>
                <li>Deployment & Performance</li>
              </ul>
            </div>
          </div>

          <!-- Course 8 -->
          <div class="col-md-6" data-aos="fade-up" data-aos-delay="1050">
            <div class="course-card">
              <div class="course-header">
                <h4 class="mb-0">Laravel Backend Development</h4>
              </div>
              <div>
                <span class="course-duration">12 Weeks</span>
                <span class="course-level">Intermediate to Advanced</span>
              </div>
              <p class="mt-3">
                Master PHP Laravel framework for building robust, scalable
                backend applications.
              </p>
              <h6 class="mt-4 mb-2">Topics Covered:</h6>
              <ul class="course-topics">
                <li>Laravel Fundamentals & Setup</li>
                <li>Database Design with Eloquent ORM</li>
                <li>Authentication & Authorization</li>
                <li>RESTful API Development</li>
                <li>Testing & Debugging</li>
                <li>Deployment & Optimization</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Student Testimonials -->
    <section class="bg-light py-5">
      <div class="container">
        <h2 class="fw-bold mb-5 text-center" data-aos="fade-up">
          Student Success Stories
        </h2>
        <div class="row g-4">
          <div class="col-md-4" data-aos="fade-up">
            <div class="testimonial-card">
              <div class="mb-3">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
              </div>
              <p class="mb-4">
                "The web development bootcamp was life-changing. Within 3 months
                of completing the course, I landed my first developer job!"
              </p>
              <h6>Rahim Hassan</h6>
              <small class="text-muted">Junior Web Developer</small>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
            <div class="testimonial-card">
              <div class="mb-3">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
              </div>
              <p class="mb-4">
                "Excellent instructors with real-world experience. The hands-on
                projects helped me understand concepts clearly and build a
                strong portfolio."
              </p>
              <h6>Fatima Khan</h6>
              <small class="text-muted">Network Administrator</small>
            </div>
          </div>

          <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="testimonial-card">
              <div class="mb-3">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
              </div>
              <p class="mb-4">
                "The Cybersecurity course provided comprehensive coverage and
                practical labs. Worth every penny. Highly recommend to anyone
                serious about tech!"
              </p>
              <h6>Ahmed Mahmud</h6>
              <small class="text-muted">Security Analyst</small>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta text-center" data-aos="fade-up">
      <div class="container">
        <h2>Ready to Start Learning?</h2>
        <p class="mt-3">Choose your course and begin your journey to success</p>
        <a href="/contact" class="btn btn-light btn-lg mt-3"
          >Enroll Today</a
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

      // Simple enrollment button handler
      document.querySelectorAll(".enroll-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
          alert(
            "Thank you for your interest! Please proceed to the Contact page to complete your enrollment.",
          );
          window.location.href = "/contact";
        });
      });
    </script>
  </body>
</html>



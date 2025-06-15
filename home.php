<!-- home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>IZANA Coffee Shop | Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
    font-family: 'Poppins', sans-serif;
      background: #fffaf5;
      scroll-behavior: smooth;
    }

    .navbar {
      background-color: #6d4c41;
    }

    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 500;
    }

    .hero {
      background: linear-gradient(rgba(255,250,245,0.9), rgba(255,250,245,0.9)), url('./assets/coffee-bg.jpeg') no-repeat center center/cover;
      padding: 120px 20px;
      text-align: center;
    }

    .hero .floating-text {
      animation: floatUp 3s ease-out forwards;
      opacity: 0;
    }

    @keyframes floatUp {
      0% {
        transform: translateY(50px);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .hero-logo-text {
      color: #6d4c41;
      font-family: 'Georgia', serif;
    }

    .hero-logo-text h1 {
      font-size: 64px;
      font-weight: bold;
      letter-spacing: 8px;
    }

    .hero-logo-text hr {
      width: 100px;
      border: 1px solid #6d4c41;
      margin: 10px auto;
    }

    .hero-logo-text p {
      font-size: 20px;
      letter-spacing: 2px;
    }

    .section-title {
      color: #6d4c41;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .about-section,
    .mission-section,
    .loyalty,
    .visit {
      padding: 60px 20px;
      background-color: #fff3e0;
      text-align: center;
    }

    .gallery {
      padding: 60px 20px;
    }

    .gallery img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
      transition: transform 0.3s;
    }

    .gallery img:hover {
      transform: scale(1.05);
    }

    .featured-drinks .card-img-top {
  height: 250px;
  object-fit: cover;
}


    .featured-drinks .card:hover {
  transform: translateY(-5px);
}


    .map-container iframe {
      width: 100%;
      height: 400px;
      border: 0;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    footer {
      background-color: #6d4c41;
      color: #fff;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }

    @media (max-width: 576px) {
      .hero-logo-text h1 {
        font-size: 36px;
        letter-spacing: 4px;
      }

      .hero-logo-text p {
        font-size: 16px;
      }

      .section-title {
        font-size: 20px;
      }

      .card-title {
        font-size: 18px;
      }

      .card-text {
        font-size: 14px;
      }

      .gallery img {
        height: 200px;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" role="navigation" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand" href="#">IZANA Coffee Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon text-white"><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="menu_preview.php">Menu Preview</a></li>

        <!-- Login Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
            <li><a class="dropdown-item" href="login.php">Customer Login</a></li>
            <li><a class="dropdown-item" href="admin_L.php">Admin Login</a></li>
          </ul>
        </li>

        <!-- Register Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="registerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Register
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="registerDropdown">
            <li><a class="dropdown-item" href="registration_C.php">Customer Register</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section id="hero" class="hero">
  <div class="hero-logo-text floating-text">
    <h1>IZANA</h1>
    <hr />
    <p>COFFEE + DESSERTS</p>
  </div>
</section>

<!-- MISSION -->
<section id="mission" class="mission-section">
  <div class="container">
    <h2 class="section-title">Brewing comfort, one cup at a time.</h2>
    <p class="lead">Get your daily dose of caffeine with us!</p>
  </div>
</section>

<!-- FEATURED DRINKS -->
<section id="featured" class="featured-drinks">
  <div class="container">
    <h2 class="section-title text-center">Signature Drinks</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-12 col-md-4">
        <div class="card p-3">
          <img src="./assets/iced-spanish.jpeg" class="card-img-top img-fluid" alt="Iced Spanish Latte in clear cup with ice">
          <div class="card-body">
            <h3 class="card-title">Iced Spanish Latte</h3>
            <p class="card-text">Smooth and sweet – our best seller loved by everyone.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card p-3">
          <img src="./assets/mango-supreme.jpg" class="card-img-top img-fluid" alt="Mango Supreme with cream topping">
          <div class="card-body">
            <h3 class="card-title">Mango Supreme</h3>
            <p class="card-text">A tropical blend of sweet mango topped with creamy goodness.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section id="about" class="about-section">
  <div class="container">
    <h2 class="section-title">About Us</h2>
    <p class="mt-3">At IZANA Coffee Shop, we keep it simple and cozy — just the way coffee should be. Conveniently located beside the highway, we’re your perfect stop for a warm brew, a quick break, or a sweet treat on the go. Whether you’re passing through or staying a while, our drinks are made with love and served with a smile.</p>
  </div>
</section>

<!-- INSTAGRAM FEED -->
<section id="gallery" class="gallery">
  <div class="container text-center">
    <h2 class="section-title">Follow Us on Instagram</h2>
    <div class="row g-3">
      <div class="col-4 col-sm-2"><img src="./assets/ig1.jpeg" class="img-fluid rounded" alt="Coffee in natural light"></div>
      <div class="col-4 col-sm-2"><img src="./assets/ig2.jpeg" class="img-fluid rounded" alt="Dessert and coffee on wooden table"></div>
      <div class="col-4 col-sm-2"><img src="./assets/ig3.jpeg" class="img-fluid rounded" alt="IZANA Coffee shop ambiance"></div>
      <div class="col-4 col-sm-2"><img src="./assets/ig4.jpeg" class="img-fluid rounded" alt="Latte art design"></div>
      <div class="col-4 col-sm-2"><img src="./assets/ig5.jpeg" class="img-fluid rounded" alt="Customer enjoying drink"></div>
      <div class="col-4 col-sm-2"><img src="./assets/ig6.jpeg" class="img-fluid rounded" alt="Mango drink in glass"></div>
    </div>
    <p class="mt-3">
      <a href="https://www.instagram.com/2021cakes_and_coffee?igsh=c3BqczNuYnBpMDAx" target="_blank" class="text-decoration-none text-dark">
        <i class="fab fa-instagram"></i> @2021cakes_and_coffee
      </a>
    </p>
  </div>
</section>

<!-- LOYALTY PROMO -->
<section id="loyalty" class="loyalty">
  <div class="container">
    <h2 class="section-title">Sip More, Earn More!</h2>
    <p>Enjoy your 6th coffee for FREE when you order 5 drinks. Ask our baristas for your loyalty card today!</p>
  </div>
</section>

<!-- VISIT US + MAP -->
<section id="visit" class="visit">
  <div class="container">
    <h2 class="section-title">Visit Us</h2>
    <p>📍 82 Batangas - Quezon Rd, San Antonio, Quezon<br>
       🕐 Mon–Sun | 9:00 AM – 7:00 PM<br>
       📞 Call/Text: 0968-307-3035</p>

    <div class="ratio ratio-16x9 mt-4">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d968.2658074808422!2d121.29104646961807!3d13.89516739915699!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd3f5495d56d5b%3A0xa7d261abaa5c97eb!2s2021%20Cafe%20San%20Antonio!5e0!3m2!1sen!2sph!4v1749842442840!5m2!1sen!2sph"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  &copy; <?= date('Y') ?> IZANA Coffee Shop. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

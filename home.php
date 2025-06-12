<!-- home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>IZANA Coffee Shop | Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fffaf5;
    }

    .navbar {
      background-color: #6d4c41;
    }

    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 500;
    }

    .hero {
      background: #fffaf5;
      padding: 80px 20px;
      text-align: center;
    }

    .hero-logo-text {
      color: #6d4c41;
      font-family: 'Georgia', serif;
    }

    .hero-logo-text h1 {
      font-size: 64px;
      margin: 0;
      font-weight: bold;
      letter-spacing: 8px;
    }

    .hero-logo-text hr {
      width: 100px;
      border: 1px solid #6d4c41;
      margin: 10px auto;
    }

    .hero-logo-text p {
      font-size: 18px;
      letter-spacing: 2px;
      margin: 0;
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

    .featured-drinks .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
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

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">IZANA Coffee Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon text-white"><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-logo-text">
    <h1>IZANA</h1>
    <hr />
    <p>COFFEE + DESSERTS</p>
  </div>
</section>

<!-- MISSION -->
<section class="mission-section">
  <div class="container">
    <h2 class="section-title">Brewing comfort, one cup at a time.</h2>
    <p class="lead">Locally roasted, passionately brewed – where every sip feels like home.</p>
  </div>
</section>

<!-- FEATURED DRINKS -->
<section class="featured-drinks">
  <div class="container">
    <h2 class="section-title text-center">Signature Drinks</h2>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="card p-3">
          <img src="./assets/iced-spanish.jpg" class="card-img-top img-fluid" alt="Iced Spanish Latte">
          <div class="card-body">
            <h5 class="card-title">Iced Spanish Latte</h5>
            <p class="card-text">Smooth and sweet – a customer favorite every season.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card p-3">
          <img src="./assets/coffee-jelly.jpg" class="card-img-top img-fluid" alt="Coffee Jelly Frappe">
          <div class="card-body">
            <h5 class="card-title">Coffee Jelly Frappe</h5>
            <p class="card-text">Rich coffee blended with fun and chewy jelly bits.</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card p-3">
          <img src="./assets/sea-salt.jpg" class="card-img-top img-fluid" alt="Sea Salt Latte">
          <div class="card-body">
            <h5 class="card-title">Sea Salt Latte</h5>
            <p class="card-text">A perfect balance of creamy and salty – unique and refreshing.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="about-section">
  <div class="container">
    <h2>About Us</h2>
    <p class="mt-3">At IZANA Coffee Shop, we serve carefully crafted brews made with passion and love. Whether you're here to study, meet friends, or simply enjoy a quiet moment, our cozy space and quality blends are just what you need.</p>
  </div>
</section>

<!-- GALLERY -->
<section class="gallery">
  <div class="container">
    <h2 class="text-center mb-5">Our Coffee Space</h2>
    <div class="row g-4">
      <div class="col-12 col-md-4"><img src="./assets/gallery1.jpg" class="img-fluid" alt="Gallery 1"></div>
      <div class="col-12 col-md-4"><img src="./assets/gallery2.jpg" class="img-fluid" alt="Gallery 2"></div>
      <div class="col-12 col-md-4"><img src="./assets/gallery3.jpg" class="img-fluid" alt="Gallery 3"></div>
    </div>
  </div>
</section>

<!-- LOYALTY PROMO -->
<section class="loyalty">
  <div class="container">
    <h2 class="section-title">Sip More, Earn More!</h2>
    <p>Enjoy your 6th coffee for FREE when you order 5 drinks. Ask our baristas for your loyalty card today!</p>
  </div>
</section>

<!-- VISIT US + MAP -->
<section class="visit">
  <div class="container">
    <h2 class="section-title">Visit Us</h2>
    <p>📍 Rosario, Batangas<br>
       🕐 Mon–Sun | 8:00 AM – 10:00 PM<br>
       📞 Call/Text: 0912-345-6789</p>

    <div class="map-container mt-4">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3870.443325983191!2d121.205!3d13.8433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0cf0d9bxxxxx%3A0x1234567890abcdef!2sRosario%2C%20Batangas!5e0!3m2!1sen!2sph!4v0000000000000!5m2!1sen!2sph" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
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

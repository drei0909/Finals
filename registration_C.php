<?php
require_once('./classes/database_customers.php');
$con = new database_customers();

$sweetAlertConfig = "";
$errorText = "";

if (isset($_POST['register'])) {
    $username = $_POST['customer_username'];
    $email = $_POST['customer_email'];
    $password = password_hash($_POST['customer_password'], PASSWORD_BCRYPT);
    $firstname = $_POST['customer_FN'];
    $lastname = $_POST['customer_LN'];
    $imagePath = '';

    // Check for duplicate username or email first
    if ($con->isUsernameExists($username)) {
        $errorText = 'The username is already taken. Please choose another.';
    } elseif ($con->isEmailExists($email)) {
        $errorText = 'This email is already registered. Try logging in.';
    } else {
        // Handle image upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_image']['tmp_name'];
            $fileName = $_FILES['profile_image']['name'];
            $fileSize = $_FILES['profile_image']['size'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (in_array($fileExt, $allowedExts)) {
                if ($fileSize <= $maxSize) {
                    $newFileName = uniqid('IMG_', true) . '.' . $fileExt;
                    $uploadDir = 'profile_image/';
                    $destPath = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $imagePath = $destPath;
                    } else {
                        $errorText = 'Failed to move uploaded image.';
                    }
                } else {
                    $errorText = 'Image file is too large. Max: 2MB.';
                }
            } else {
                $errorText = 'Invalid image format. Only JPG, PNG, and GIF are allowed.';
            }
        }

        if (empty($errorText)) {
            $userID = $con->signupUser($firstname, $lastname, $username, $email, $password, $imagePath);

            if ($userID) {
                $sweetAlertConfig = "
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Welcome to IZANA!',
                        text: 'Registration successful.',
                        confirmButtonText: 'Go to Home'
                    }).then(() => {
                        window.location.href = 'home.php';
                    });
                });
                </script>";
            } else {
                $errorText = 'Registration failed due to a system error. Please try again.';
            }
        }
    }

    if (!empty($errorText)) {
        $sweetAlertConfig = "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Registration Failed',
                text: '$errorText',
                confirmButtonText: 'OK'
            });
        });
        </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>IZANA | Register</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- SweetAlert2 -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(to right, #f5f0eb, #ede0d4);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper {
      background: #fff;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    .form-title {
      font-size: 2rem;
      font-weight: 700;
      color: #4e342e;
      text-align: center;
      margin-bottom: 0.5rem;
    }

    .form-subtitle {
      text-align: center;
      font-size: 0.95rem;
      color: #8d6e63;
      margin-bottom: 1.5rem;
    }

    .form-group {
      position: relative;
      margin-bottom: 1.5rem;
    }

    .form-group i {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #8d6e63;
      z-index: 2;
      font-size: 1rem;
    }

    .form-group input {
      padding-left: 2.5rem;
      border-radius: 10px;
      height: 48px;
    }

    .form-group label {
      position: absolute;
      top: -10px;
      left: 45px;
      background-color: #fff;
      padding: 0 5px;
      font-size: 0.85rem;
      color: #6d4c41;
    }

    .btn-primary {
      background-color: #6d4c41;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 0.75rem;
      transition: 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #5d4037;
    }

    .btn-secondary {
      margin-top: 0.75rem;
      background-color: transparent;
      color: #6d4c41;
      border: 2px solid #6d4c41;
      font-weight: 600;
      border-radius: 10px;
      padding: 0.65rem;
      transition: 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: #6d4c41;
      color: #fff;
    }

    footer {
      text-align: center;
      font-size: 0.85rem;
      color: #a1887f;
      margin-top: 2rem;
    }

    .logo-container img {
      width: 120px;
      height: auto;
      display: block;
      margin: 0 auto 1.5rem;
      transition: transform 0.3s ease;
    }

    .logo-container img:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body>
  
  <div class="form-wrapper">
    <!-- Logo -->
    <div class="logo-container">
      <img src="./assets/izana-logo.jpg" alt="IZANA Logo" />
    </div>

    <!-- Title and Subtitle -->
    <div class="form-title">Create Your Account</div>
    <div class="form-subtitle">Join IZANA and enjoy the finest blends with ease.</div>

    <!-- Registration Form -->
   <form id="registrationForm" method="POST" enctype="multipart/form-data" novalidate>
<form method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <i class="fa fa-user"></i>
        <input type="text" name="customer_FN" id="first_name" class="form-control" required>
        <label for="first_name">First Name</label>
      </div>

      <div class="form-group">
        <i class="fa fa-user"></i>
        <input type="text" name="customer_LN" id="last_name" class="form-control" required>
        <label for="last_name">Last Name</label>
      </div>

      <div class="form-group">
        <i class="fa fa-user-circle"></i>
        <input type="text" name="customer_username" id="username" class="form-control" required>
        <label for="username">Username</label>
      </div>

      <div class="form-group">
        <i class="fa fa-envelope"></i>
        <input type="email" name="customer_email" id="email" class="form-control" required>
        <label for="email">Email</label>
      </div>

      <div class="form-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="customer_password" id="password" class="form-control" required>
        <label for="password">Password</label>
      </div>

<div class="form-group">
  <i class="fa fa-image"></i>
  <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/png, image/jpeg, image/gif" required>
  <label for="profile_image">Profile Image (JPG, PNG, GIF)</label>
</div>



      <button type="submit" name="register" class="btn btn-primary w-100">Register</button>

      <!-- Login and Home Links -->
      <a href="login.php" class="btn btn-secondary w-100">Already have an account? Login</a>

      <a href="home.php" class="btn btn-outline-secondary w-100 mt-2">
        <i class="fa fa-home me-1"></i> Back to Home
      </a>
    </form>

    <footer>
      © <?= date("Y") ?> IZANA Coffee Shop. Crafted with care.
    </footer>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?= $sweetAlertConfig ?>

  <!-- Password Validation -->
<script>
  const form = document.getElementById('registrationForm');
  const firstName = document.getElementById('first_name');
  const lastName = document.getElementById('last_name');
  const username = document.getElementById('username');
  const email = document.getElementById('email');
  const password = document.getElementById('password');

  function clearAllFields() {
    firstName.value = '';
    lastName.value = '';
    username.value = '';
    email.value = '';
    password.value = '';
  }

  function isPasswordValid(value) {
    return /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$/.test(value);
  }

  function isEmailValid(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
  }

  // Clear autofilled andrei + 3-letter password
  window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      const uname = username.value.trim().toLowerCase();
      const passLength = password.value.trim().length;

      if (uname === 'andrei' && passLength >= 3) {
        clearAllFields();
        Swal.fire({
          icon: 'info',
          title: 'Fields Cleared',
          text: 'Autofilled "andrei" and password detected and cleared. Please enter your details again.'
        });
      }
    }, 300);
  });

  // Form validation
  form.addEventListener('submit', function (e) {
    const fn = firstName.value.trim();
    const ln = lastName.value.trim();
    const un = username.value.trim();
    const em = email.value.trim();
    const pw = password.value.trim();

    if (!fn || !ln || !un || !em || !pw) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Missing Fields',
        text: 'Please fill in all fields before registering.'
      });
      return;
    }

    if (!isEmailValid(em)) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Invalid Email',
        text: 'Please enter a valid email format (e.g. you@example.com).'
      });
      return;
    }

    if (!isPasswordValid(pw)) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Weak Password',
        text: 'Password must be at least 6 characters, with 1 uppercase letter, 1 number, and 1 special character.'
      });
      return;
    }

    // passed all custom validations
    form.classList.add('was-validated');
  });
</script>


</body>
</html>
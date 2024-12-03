<?php
// Koneksi ke database
session_start();
require_once "connection.php";

$conn = getConnection();

if (isset($_SESSION["UserID"])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="Assets/index.css" />
    <title>Buku Kas (Catatan Pemasukan & Pengeluaran)</title>
</head>

<body>
    <div class="container" id="container">
        <!-- FORM SIGN UP  -->
        <div class="form-container sign-up">
            <form action="proses_signup.php" method="post" class="form" id="signupForm">
                <h1>SignUp</h1>
                <input
                type="text"
                placeholder="Username"
                name="username"
                maxlength="8";
                required
                />
                <input
                type="password"
                placeholder="Password"
                name="password1"
                maxlength="8";
                required
                />
                <input
                type="password"
                placeholder="Confirm Password"
                name="password2"
                maxlength="8";
                required
                />
             
                <button type="submit" name="action" value="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="proses_signin.php" method="post" class="form">
                <img src="img/logo.jpg" width="200" height="200" alt="Logo" />
                <input
                    type="text"
                    placeholder="Username"
                    name="username"
                    maxlength="8";
                    required
                />
                <input
                    type="password"
                    placeholder="Password"
                    name="password"
                    maxlength="8";
                    required
                />
                
                <button type="submit" name="action" value="signin">Sign In </button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <button class="hidden" id="login" onclick="toggleSignIn()">
                        Sign In
                    </button>
                </div>
                <div class="toggle-panel toggle-right">
                    <br />
                    <button class="hidden" id="register" onclick="toggleSignUp()">
                        Sign Up 
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
      const container = document.getElementById("container");
const registerBtn = document.getElementById("register");
const loginBtn = document.getElementById("login");

registerBtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
  container.classList.remove("active");
});

let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides((slideIndex += n));
}

function currentSlide(n) {
  showSlides((slideIndex = n));
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}
    </script>
</body>
</html>

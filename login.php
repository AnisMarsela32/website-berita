<!doctype html>
<html lang="en">

<head>
   <title>Login</title>
   <link rel="stylesheet" href="style.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


   <link rel="stylesheet" href="layout/css/login.css">

</head>

<body>

   <div class="wrapper">

      <div class="title-text">
         <div class="title login">
            Login
         </div>
         <div class="title signup">
            Signup Form
         </div>
      </div>

      <div class="form-container">

         <!-- <div class="slide-controls">
            <input type="radio" name="slide" id="login" checked>
            <input type="radio" name="slide" id="signup">
            <label for="login" class="slide login">Login</label>
            <label for="signup" class="slide signup">Signup</label>
            <div class="slider-tab"></div>
         </div> -->

         <div class="form-inner mt-5">
            <form action="proses_login.php" method="post" class="login">
               <div class="field">
                  <input type="text" placeholder="Username" name="username" required>
               </div>
               <div class="field">
                  <input type="password" placeholder="Password" name="password">
               </div>
               <!-- <div class="pass-link">
                  <a href="#">Forgot password?</a>
               </div> -->
               <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Login">
               </div>
               <div class="signup-link">
                  <!-- Not a member? <a href="">Signup now</a> -->
               </div>
            </form>


            <!-- <form action="" method="post" class="signup">
               <div class="field">
                  <input type="text" placeholder="Username" name="username" required>
               </div>
               <div class="field">
                  <input type="password" placeholder="Password" name="password">
               </div>
               <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Signup">
               </div>
            </form> -->
         </div>
      </div>
   </div>
   <script>
      const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = (() => {
         loginForm.style.marginLeft = "-50%";
         loginText.style.marginLeft = "-50%";
      });
      loginBtn.onclick = (() => {
         loginForm.style.marginLeft = "0%";
         loginText.style.marginLeft = "0%";
      });
      signupLink.onclick = (() => {
         signupBtn.click();
         return false;
      });
   </script>
</body>

</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
</script>
</body>


<?php

include 'koneksi.php';
$db = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Ambil data dari formulir pendaftaran
   $username = $_POST["username"];
   $password = $_POST["password"];

   // Validasi data (contoh sederhana)
   if (empty($username) || empty($password)) {
      $error = "Username dan password harus diisi.";
   } else {
      // Hash password (disarankan)
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Simpan data pengguna ke basis data (gantilah dengan koneksi basis data Anda)
      $query = mysqli_query($db->koneksi, "INSERT INTO user (username, password, role_id) VALUES ('$username', '$hashedPassword', '2')");

      if ($query) {
         echo "<script>
         Swal.fire({
             title: 'Register Berhasil',
             text: 'Silahkan Login.',
             icon: 'success',
             confirmButtonText: 'OK'
         }).then(function() {
             window.location.href = 'login.php?';
         });
         
         </script>";
      } else {
         // Handle kesalahan jika gagal menyimpan ke basis data
         echo '<script>
            Swal.fire({
                title: "Register Gagal",
                text: "Silahkan coba lagi.",
                icon: "error",
                confirmButtonText: "OK"
            });
          </script>';
      }

      mysqli_close($db->koneksi);
   }
}


?>
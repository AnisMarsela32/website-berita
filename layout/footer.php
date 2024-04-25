<footer class="bg-dark py-3 mt-5">
  <div class="container">
    <div class="row">

      <div class="col-6">
        <img src="image/lorong_berita_logo.png" alt="" style="width: 150px;"><br>
      </div>

      <div class="col-6">
        <div class="medsos text-end">
          <a href=""><i class="fab fa-facebook-f"></i></a>
          <a href=""><i class="fab fa-twitter"></i></a>
          <a href=""><i class="fab fa-instagram"></i></a>
          <a href=""><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
    </div>
  </div>

  </div>
  <hr class="text-white mt-3">
  <p class="text-white text-center mb-0">&copy; 2023 Company, Inc. All rights reserved.</p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5rFBF+T6F6Zxu2wAbeSzTpacJJg2auqV8=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>


<script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>

    <script>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })
    </script>

<script>
  $(document).ready(function() {
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('nav').outerHeight();

    $(window).scroll(function(event) {
      var st = $(this).scrollTop();

      // Scroll down
      if (st > lastScrollTop && st > navbarHeight) {
        $('nav').removeClass('navbar-show').addClass('navbar-hide');
      } else {
        // Scroll up
        if (st + $(window).height() < $(document).height()) {
          $('nav').removeClass('navbar-hide').addClass('navbar-show');
        }
      }

      lastScrollTop = st;
    });
  });
</script>

<!-- JavaScript untuk smooth scroll ke atas -->
<script>
    // Menampilkan atau menyembunyikan tombol "To the Top" berdasarkan posisi scroll
    window.onscroll = function() {
      scrollFunction();
    };

    function scrollFunction() {
      var toTopButton = document.getElementById("toTopBtn");
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        toTopButton.style.display = "block";
      } else {
        toTopButton.style.display = "none";
      }
    }

    // Fungsi untuk melakukan scroll ke atas dengan efek yang halus dan jeda
    function scrollToTop() {
      // Menambahkan efek animasi smooth scroll
      $('html, body').animate({
        scrollTop: 0
      }, 800); // Durasi animasi 800 milidetik (0.8 detik)
    }
  </script>
</body>

</html>
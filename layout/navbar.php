  <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
        <div class="container" >
          <a class="navbar-brand" href="index.php" data-aos="fade-right" data-aos-duration="800"><img src="assets/images/H logo.png" alt="" style="width:60px;height:auto;background:transparent;" class="logo-img"> <span style="color: #000;">Htoo Blog</span></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" data-aos="fade-left" data-aos-duration="800">
              <?php if(isset($_SESSION['user'])): ?>
                <form method="post">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <span style="color: #000;"><?php echo htmlspecialchars($_SESSION['user']->name); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="#">Profile</a></li>
                      <li><button class="dropdown-item" name="logOutBtn" onclick="return confirm('Are you sure you want to log out?');">Logout</button></li>
                    </ul>
                  </li>
                </form>
              <?php else: ?>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#signIn" data-bs-toggle="offcanvas" aria-controls="staticBackdrop"><span style="color: #000;">Sign In</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#signUp" data-bs-toggle="offcanvas" aria-controls="staticBackdrop"><span style="color: #000;">Sign Up</span></a>
              </li>
              <?php endif; ?>

            </ul>
          </div>
        </div>
    </nav>
<?php 
  if(isset($_POST['logOutBtn'])) {
    session_destroy();
    header("Location: index.php");
    exit(); 
  }
?>
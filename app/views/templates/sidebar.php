<?php
require_once 'core/start.php';

$user = new User();
?>

<header class="site-header">
    <div class="site-branding">
        <h1 class="site-title"><a href="home.php" rel="home"><img src="<?php echo BASE_URL; ?>/images/logo.png" alt="Logo"></a></h1>
    </div><!-- .site-branding -->

    <div class="hamburger-menu">
        <div class="menu-icon">
            <img src="<?php echo BASE_URL; ?>images/menu-icon.png" alt="menu icon">
        </div><!-- .menu-icon -->

        <div class="menu-close-icon">
            <img src="<?php echo BASE_URL; ?>images/x.png" alt="menu close icon">
        </div><!-- .menu-close-icon -->
    </div><!-- .hamburger-menu -->
</header><!-- .site-header -->

<nav class="site-navigation flex flex-column justify-content-between">
    <div class="site-branding d-none d-lg-block ">
        <h1 class="site-title"><a href="home.php" rel="home"><img src="<?php echo BASE_URL; ?>images/logo2.png" alt="Logo"></a></h1>
    </div><!-- .site-branding -->

    <ul class="main-menu flex flex-column justify-content-center">
        <li><a href="home.php">Home</a></li>
        <li><a href="portfolio.php">Portfolio</a></li>
        <li><a href="blog.php">Blog</a></li>
        <?php if($user->isLoggedIn()) : ?>
        <li><a href="profile.php">Profile</a></li>
        <?php endif; ?>
    </ul>

    <div class="social-profiles">
        <ul class="flex justify-content-start justify-content-lg-center align-items-center">
            <li><a href="https://www.facebook.com/republicesports/" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://www.instagram.com/joechegne/" target="_blank"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><?php if(!$user->isLoggedIn()) : ?><div onClick="location.href='login.php';"><?php else : ?>
            <div onClick="document.getElementById('logintrigger').style.display='block'"><?php endif; ?><i class="fa fa-key"></i></div></a></li>
        </ul>
    </div><!-- .social-profiles -->

    <p class="text-center" style="font-size: 0.8rem;"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0.-->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Template made by <a href="https://colorlib.com" target="_blank">Colorlib</a>
	</p>
</nav><!-- .site-navigation -->

<div id="logintrigger" class="modal logintrigger">
<div class="nav-bar-sep d-lg-none"></div> <!-- Modal --> 
  <div class="modal-content animate" action="/action_page.php">
    <span onclick="document.getElementById('logintrigger').style.display='none'" 
    class="close" title="Close Modal">&times;
    </span> 
    <div class="loginmodal-container">
        <h1>Logout</h1>
        <form action="logout.php" method="post">
            <p>Confirm Logout?</p>
            <input type="submit" id="submit" name="submit" class="login loginmodal-submit" value="Logout">
        </form>
    </div>
  </div>
</div>  <!-- Modal Content -->



<?php require VIEW_ROOT . '/templates/header.php'; ?>
<?php require VIEW_ROOT . '/templates/sidebar.php'; ?>

<?php if(!$user->isLoggedIn()) {
    Redirect::to('home.php');}
?>

<div class="outer-container">
    <article id="slide01" class="section-1 fs">
        <div class="container portfolio-page">
           <div class="row">
            <div class="col">
                <ul class="breadcrumbs flex align-items-center">
                    <li><a href="home.php">Home</a></li>
                    <li>Profile</li>
                </ul><!-- .breadcrumbs -->
            </div><!-- .col -->
          </div><!-- .row -->

        <div class="row list-row">
            <div class="row">
                <div class="col-12">
                    <p>Hello <?php echo escape($user->data()->username); ?>!</p>
                    <?php 
                        if($user->hasPermission('admin')) {
                                echo '<p>You are a admin!</p>';} ?>
                    <ul>
                        <li><a href="logout.php">Logout</a></li>
                        <li><a href="update.php">Update Details</a></li>
                        <li><a href="changepassword.php">Change Password</a></li>
                    </ul>
                    <?php if($user->hasPermission('moderator')) :?>
                    <p><b>Administrative Panels</b></p>
                    <ul>
                        <li><a href="panel.php">Portfolio Management</a></li>
                        <li><a href="panel2.php">Blog Management</a></li>
                    </ul>
                    <?php endif; ?>
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .list-row -->
    </div><!-- .container -->
</div><!-- .outer-container -->

<?php require VIEW_ROOT . '/templates/footer.php'; ?>

<!-- 
//***Example Usage with Classes***
//$user = DB::getInstance()->get('users', array('username', '=', 'alex'));
//if(Session::has('success')) {
//echo <div class>
//  echo Session::flash('success');
//echo </div>
//}
-->
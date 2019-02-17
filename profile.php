<?php //require VIEW_ROOT . '/templates/header.php'; ?>
<?php //require VIEW_ROOT . '/templates/sidebar.php'; ?>

<?php if(!$user->isLoggedIn()) {
    Redirect::to('home.php');}
?>
<link href="../css/profile.css" rel="stylesheet">
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Montserrat:300,400,600,700&amp;lang=en" />
<div class="outer-container">
    <article id="slide01" class="section-1 fs">
        

        <div class="row list-row">
            <div class="row">
                <div class="col-12">
                    <p>Welcome back, User!</p>
                  <ul> 
                       <input type="button" onclick="update.php" value="Update Details"/>
                    
                        <input type="button" onclick="changepassword.php" style="margin:50px" value="Change Password"/>
                    </ul>
                    
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
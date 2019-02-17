<?php require APP_ROOT . 'views/templates/header.php';
      require APP_ROOT . 'views/templates/navbar.php'; ?>

<?php $user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
}

if($user->examReady($user->data()->id)) {
    echo "You are ready for exam";
} else {
     echo "You are not ready for exam";
}
?>

<p>Welcome back, User!</p>
    <ul> 
        <li><a href="updatedetails.php">Update Details</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
        <?php if($user->examReady($user->data()->id)): ?>
            <li><a href="exam.php">Take Exam</a></li>
        <?php else : ?>
            <li><a href="lesson.php">Take Lesson</a></li>
        <?php endif; ?>
    </ul>

<?php require APP_ROOT . 'views/templates/footer.php'; ?>
<?php require APP_ROOT . 'views/templates/header.php';?>

<?php $user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
} ?>

<body id="page-top">

<?php
if($user->examReady($user->data()->id)) {
    echo "You are ready for the exam";
} else {
     echo "You are not ready for the exam";
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
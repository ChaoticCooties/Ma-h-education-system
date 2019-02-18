<?php require APP_ROOT . 'views/templates/header.php';?>

<?php $user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
} ?>

<body id="page-top">

<p>Welcome back, User!</p>
<ul> 
    <li><a href="home.php">Home</a></li>
    <li><a href="updatedetails.php">Update Details</a></li>
    <li><a href="changepassword.php">Change Password</a></li>
    <li><a href="logout.php">Logout</a></li>
    <?php if($user->hasPlacement($user->data()->id)): ?>
        <?php if($user->examReady($user->data()->id)): ?>
            <li><a href="exam.php">Take Exam</a></li>
        <?php else : ?>
            <li><a href="lesson.php">Take Lesson</a></li>
        <?php endif; ?>
    <?php else : ?>
        <li><a href="placement.php">Take Placement Test</a></li>
    <?php endif; ?>
</ul>

<?php if($user->hasPermission('teacher')): ?>
<h1><b>Teacher Panel</b></h1>
<ul>
    <li><a href="feedback.php">Feedback</a></li>
    <li><a href="report.php">View Report</a></li>
    <li><a href="generatecode.php">Get Invite Link</a></li>
</ul>
<?php endif; ?>

<?php if($user->hasPermission('admin')): ?>
<h1><b>Admin Panel</b></h1>
<ul>
    <li><a href="viewfeedbacklist.php">View Feedback List</a></li>
<ul>
<?php endif; ?>


<?php require APP_ROOT . 'views/templates/footer.php'; ?>
<?php

require "../core/start.php";

$user = new User();
if(!$user->isLoggedIn()) {
  Redirect::to('home.php');
}
if(!$user->hasPermission("moderator")) {
  Redirect::to('home.php');
}

$id = $user->data()->id;

/* Connect to database */
$conn = mysqli_connect('localhost','root','','sdp');
/* Checks for error */
if(mysqli_connect_errno()) {
  die('<script>alert("Connection failed: Please check your SQL connnection!");</script>');
}

$sql = "SELECT classID FROM user_class WHERE userID = $id";

$result = mysqli_query($conn, $sql);

if(mysqli_affected_rows($conn) <=0)
{
  Session::flash("home", "Class not found");
} else {
  $row = mysqli_fetch_assoc($result);
  $classID = $row["classID"];
}

$sqlProgress = "SELECT u.name, p.gradeNo, p.lessonNo FROM user_class c INNER JOIN users u ON c.userID = u.id INNER JOIN student_progress p ON c.userID = p.studentID WHERE c.classID = $classID";
$resultProgress = mysqli_query($conn, $sqlProgress);
if(mysqli_affected_rows($conn) <= 0) {
  $errorProgress = "no result found";
} else {
  $errorProgress = "";
}

$sqlResult = "SELECT u.name, r.gradeNo, r.percentage FROM user_class c INNER JOIN users u ON c.userID = u.id INNER JOIN results r ON c.userID = r.studentID WHERE c.classID = $classID";
$resultResult = mysqli_query($conn, $sqlResult);
if(mysqli_affected_rows($conn) <= 0) {
  $errorResult = "no result found";
} else {
  $errorResult = "";
}

require VIEW_ROOT . "/report.php";

?>

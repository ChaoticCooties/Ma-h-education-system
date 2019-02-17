<?php

require '../core/start.php';

$user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
}
//STUDENT ONLY

$id = $user->data()->id;

/* Connect to database */
$conn = mysqli_connect('localhost','root','','sdp');
/* Checks for error */
if(mysqli_connect_errno()) {
  die('<script>alert("Connection failed: Please check your SQL connnection!");</script>');
}

$sql = "SELECT p.gradeNo, p.lessonNo FROM student_progress p LEFT JOIN users u ON p.studentID = u.id WHERE u.id = $id ORDER BY p.gradeNo DESC, p.lessonNo DESC";

$result = mysqli_query($conn, $sql);

if(mysqli_affected_rows($conn) <=0)
{
  echo $sql;
} else {
  $row = mysqli_fetch_assoc($result);

  if ($row["lessonNo"] == 4) {
    $grade = $row["gradeNo"] + 1;
    $lesson = 1;
  } else {
    $grade = $row["gradeNo"];
    $lesson = $row["lessonNo"];
  }

  if (isset($_POST["submit"])) {
    $lesson += 1;
    if ($lesson > 4) {
      $grade += 1;
      $lesson = 1;
    }
    $sql = "UPDATE student_progress SET gradeNo = $grade, lessonNo = $lesson WHERE studentID = $id";
    mysqli_query($conn, $sql);
    echo "<script>window.location.href='lesson.php';</script>";
  }

  $sql2 = "SELECT lesson FROM lesson WHERE gradeNo = $grade AND lessonNo = $lesson";

  $result = mysqli_query($conn, $sql2);

  if(mysqli_affected_rows($conn) <=0) {
    echo $sql2;
  } else {
    $row = mysqli_fetch_assoc($result);
    $lessonText = $row["lesson"];
  }
}

$title = "Grade " . $grade . " - Lesson " . $lesson;

$arrayAddSub = array(5, 50, 500, 5000);
$arrayMultDiv = array(5, 10, 20, 100);

$arrayQuiz = array();

for ($j = 0; $j < 10; $j++) {
  $tempArray = array();
  if ($grade <= 2) {
    $randomX = rand(0, $arrayAddSub[$lesson - 1]);
    $randomY = rand(0, $arrayAddSub[$lesson - 1]);
  } else {
    $randomX = rand(1, $arrayMultDiv[$lesson - 1]);
    $randomY = rand(1, $arrayMultDiv[$lesson - 1]);
  }

  switch ($grade) {
    case 1:
      array_push($tempArray, $randomX . " + " . $randomY);
      array_push($tempArray, $randomX + $randomY);
      break;
    case 2:
      array_push($tempArray, $randomX . " - " . $randomY);
      array_push($tempArray, $randomX - $randomY);
      break;
    case 3:
      array_push($tempArray, $randomX . " * " . $randomY);
      array_push($tempArray, $randomX * $randomY);
      break;
    case 4:
      array_push($tempArray, $randomX . " / " . $randomY);
      array_push($tempArray, floor($randomX / $randomY) . " r " . $randomX % $randomY);
      break;
  }

  array_push($arrayQuiz, $tempArray);
}

//$arrayQuiz = [question1 = [question,answer], question2 = [question,answer], ... ]

require VIEW_ROOT . '/lesson.php';

?>

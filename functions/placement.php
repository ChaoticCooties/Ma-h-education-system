<?php

require "../core/start.php";

$user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
}
$id = $user->data()->id;

/* Connect to database */
$conn = mysqli_connect('localhost','root','','sdp');
/* Checks for error */
if(mysqli_connect_errno()) {
  die('<script>alert("Connection failed: Please check your SQL connnection!");</script>');
}

$sql = "SELECT * FROM student_progress WHERE studentID = $id";

mysqli_query($conn, $sql);

if(mysqli_affected_rows($conn) > 0) {
  Redirect::to('home.php');
} else {
  if (!isset($_SESSION["placementGrade"])) {
    $_SESSION["placementGrade"] = 1;
    $_SESSION["placementLesson"] = 1;
    $_SESSION["placementError"] = 0;
  }

  if (isset($_POST["answer"])) {
    if (!($_POST["answer"] == $_SESSION["placementQ"][1])) {
      $_SESSION["placementError"] += 1;
    } else {
      $_SESSION["placementLesson"] += 1;
    }
  }

  if ($_SESSION["placementLesson"] > 4) {
    $_SESSION["placementGrade"] += 1;
    $_SESSION["placementLesson"] = 1;
  }

  if ($_SESSION["placementError"] > 2) {
    $grade = $_SESSION["placementGrade"];
    $sql = "INSERT INTO student_progress (studentID, gradeNo, lessonNo) VALUES ($id,$grade,1)";
    mysqli_query($conn, $sql);
    Redirect::to('home.php');
  }

  if ($_SESSION["placementGrade"] > 4) {
    Redirect::to('home.php');
  }

  $grade = $_SESSION["placementGrade"];
  $lesson = $_SESSION["placementLesson"];

  //Generate question and answers
  $arrayAddSub = array(5, 50, 500, 5000);
  $arrayMultDiv = array(5, 10, 20, 100);

  if ($grade <= 2) {
    $randomX = rand(0, $arrayAddSub[$lesson -1]);
    $randomY = rand(0, $arrayAddSub[$lesson -1]);
  } else {
    $randomX = rand(1, $arrayMultDiv[$lesson -1]);
    $randomY = rand(1, $arrayMultDiv[$lesson -1]);
  }

  $arrayQuiz = array();

  switch ($grade) {
    case 1:
      array_push($arrayQuiz, $randomX . " + " . $randomY);
      array_push($arrayQuiz, $randomX + $randomY);
      $arrayAnswers = array($randomX + $randomY, $randomX + $randomY + 1, $randomX + $randomY - 1, $randomX + $randomY + 2);
      break;
    case 2:
      array_push($arrayQuiz, $randomX . " - " . $randomY);
      array_push($arrayQuiz, $randomX - $randomY);
      $arrayAnswers = array($randomX - $randomY, $randomX - $randomY + 1, $randomX - $randomY - 1, $randomX - $randomY + 2);
      break;
    case 3:
      array_push($arrayQuiz, $randomX . " * " . $randomY);
      array_push($arrayQuiz, $randomX * $randomY);
      $arrayAnswers = array($randomX * $randomY, $randomX * $randomY + 1, $randomX * $randomY - 1, $randomX * $randomY + 2);
      break;
    case 4:
      array_push($arrayQuiz, $randomX . " / " . $randomY);
      array_push($arrayQuiz, floor($randomX / $randomY) . " r " . $randomX % $randomY);
      $arrayAnswers = array(floor($randomX / $randomY) . " r " . $randomX % $randomY, floor($randomX / $randomY) + 1 . " r " . $randomX % $randomY, floor($randomX / $randomY) - 1 . " r " . $randomX % $randomY, floor($randomX / $randomY) + 2 . " r " . $randomX % $randomY);
      break;
  }

  shuffle($arrayAnswers);

  for ($i = 0; $i < count($arrayAnswers); $i++) {
    array_push($arrayQuiz, $arrayAnswers[$i]);
  }
  //$arrayQuiz = [question,correct answer,A,B,C,D]
  $_SESSION["placementQ"] = $arrayQuiz;
  //save question for later
  print_r($_SESSION["placementQ"]);
}

require VIEW_ROOT . '/placement.php';

?>

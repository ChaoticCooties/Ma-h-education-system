<?php

require '../core/start.php';

$user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
}
//student only

$id = $user->data()->id;

/* Connect to database */
$conn = mysqli_connect('localhost','root','','sdp');
/* Checks for error */
if(mysqli_connect_errno()) {
  die('<script>alert("Connection failed: Please check your SQL connnection!");</script>');
}

$sql = "SELECT gradeNo, lessonNo FROM student_progress WHERE studentID = $id";

$result = mysqli_query($conn, $sql);

if(mysqli_affected_rows($conn) <= 0) {
  echo "fail";
  exit;
} else {
  $row = mysqli_fetch_assoc($result);

  if ($row["lessonNo"] != 5) {
    Redirect::to("profile.php");
  } else {
    $grade = $row["gradeNo"];
    $sql = "SELECT * FROM results WHERE studentID = $id AND gradeNo = $grade";

    $result = mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0) {
      $grade += 1;
      $sqlInsert = "UPDATE student_progress SET gradeNo = $grade, lessonNo = 1 WHERE studentID = $id";
      mysqli_query($conn, $sqlInsert);
      Redirect::to("profile.php");
    }
  }
}

$grade = $row["gradeNo"];

$title = "Exam - Grade " . $grade;

//fetch exam from database
$sql2 = "SELECT * FROM exam WHERE gradeNo = $grade";
$result = mysqli_query($conn, $sql2);

$examArray = [];

if(mysqli_affected_rows($conn) <= 0) {
  echo "fail";
} else {
  while ($row = mysqli_fetch_assoc($result)) {
    $tempArray = [];
    array_push($tempArray, $row["questionNo"], $row["question"], $row["answer"], $row["answer1"], $row["answer2"], $row["answer3"], $row["answer4"]);
    array_push($examArray, $tempArray);
  }
}

if (!isset($_SESSION["examAns"])) {
  $_SESSION["examAns"] = [];

  for ($i = 0; $i < count($examArray); $i++) {
    $_SESSION["examAns"][$i] = "";
  }
}

if (isset($_POST["answer"])) {
  $_SESSION["examAns"][$_GET["q"] - 1] = $_POST["answer"];
}

if (!isset($_GET["q"])) {
  echo "<script>window.location.href='exam.php?q=0';</script>";
}

if ($_GET["q"] >= count($examArray)) {
  $count = count($examArray) - 1;
  echo "<script>window.location.href='exam.php?q=$count';</script>";
}

if (isset($_POST["submit"])) {
  $result = 0;
  for ($i = 0; $i < count($examArray); $i++) {
    if ($examArray[$i][2] == $_SESSION["examAns"][$i]) {
      $result += 1;
    }
  }
  $result = $result / count($examArray) * 100;
  $datetime = date("Y-m-d H:i:s");

  $sql3 = "INSERT INTO results (studentID, gradeNo, percentage, datetime) VALUES ($id, $grade, $result, '$datetime')";
  mysqli_query($conn, $sql3);

  if(mysqli_affected_rows($conn) <= 0) {
    echo $sql3;
    exit;
  } else {
    $grade += 1;
    $sql4 = "UPDATE student_progress SET gradeNo = $grade, lessonNo = 1 WHERE studentID = $id";
    mysqli_query($conn, $sql4);

    if(mysqli_affected_rows($conn) <= 0) {
      echo $sql4;
      exit;
    } else {
      Redirect::to("home.php");
    }
  }
}

require VIEW_ROOT . '/exam.php';

?>

<!DOCTYPE html>
<html>
<head>
  <title>Class Report</title>
  <link rel="stylesheet" href="../css/report.css" type="text/css">
</head>
<body>
  <div class="ptitle">
    Progress
  </div>
  <div class="rtitle">
    Result
  </div>
  <div class="progress">
    <table>
      <tr>
        <th>Name</th>
        <th>Grade</th>
        <th>Lesson</th>
      </tr>
      <?php
        echo "<td>".$errorProgress."</td>";
        while($row = mysqli_fetch_assoc($resultProgress)) {
          echo "<tr>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["gradeNo"]."</td>";
            echo "<td>".$row["lessonNo"]."</td>";
          echo "</tr>";
        }
      ?>
    </table>
  </div>
  <div class="result">
    <table>
      <tr>
        <th>Name</th>
        <th>Grade</th>
        <th>Result</th>
      </tr>
      <?php
        echo "<td>".$errorResult."</td>";
        while($row = mysqli_fetch_assoc($resultResult)) {
          echo "<tr>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["gradeNo"]."</td>";
            echo "<td>".$row["percentage"]."</td>";
          echo "</tr>";
        }
      ?>
    </table>
  </div>
</body>
</html>

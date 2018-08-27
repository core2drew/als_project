<?php
  require '../config/db_connect.php';
  $query = "SELECT id, question, explanation from questions";
  $question_result = mysqli_query($conn, $query);
?>

<table id="QuestionsTable" class="table">
  <thead>
    <th>Question</th>
    <th>Choice 1</th>
    <th>Choice 2</th>
    <th>Choice 3</th>
    <th>Choice 4</th>
    <th>Answer</th>
    <th>Options</th>
  </thead>
  <tbody>
    <?php
      while($question_rows = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
          echo "<tr>";
            foreach($question_rows as $key => $value) {
              if($key !== 'id') {
                echo  "<td>" . $value ."</td>";
              }
            }
            echo  "<td>".$question_rows['explanation']."</td>";
            echo  "<td><button class='button remove' value=".$question_rows['id'].">Remove</button></td>";
          echo "</tr>";
      }
    ?>
  </tbody>
</table>
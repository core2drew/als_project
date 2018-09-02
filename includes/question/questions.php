<?php
  require '../config/db_connect.php';
  $query = "SELECT id, question, explanation FROM questions";
  $question_result = mysqli_query($conn, $query);
?>

<table id="QuestionsTable" class="table">
  <thead>
    <th>Question</th>
    <th>Choice 1</th>
    <th>Choice 2</th>
    <th>Choice 3</th>
    <th>Choice 4</th>
    <th>Options</th>
  </thead>
  <tbody>
    <?php
      while($question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
          $question_id = $question_row['id'];
          $question = $question_row['question'];
          echo "<tr>";
            echo "<td>$question</td>";
            $query = "SELECT answer FROM answers WHERE question_id='$question_id'";
            $answer_result = mysqli_query($conn, $query);
            while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
              foreach($answer_row as $key => $value) {
                echo  "<td>$value</td>";
              }
            }
            echo  "<td><button class='button remove' value='$question_id'>Remove</button></td>";
          echo "</tr>";
      }
    ?>
  </tbody>
</table>
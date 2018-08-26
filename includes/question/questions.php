<?php
  require '../config/db_connect.php';
  $query = "SELECT * from questions";
  $result = mysqli_query($conn, $query);
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
      while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          echo "<tr>";
            foreach($rows as $key => $value) {
              if($key !== 'id' && $key !== 'topic_id' && $key !== 'topic_id' && $key !== 'explanation') {
                echo  "<td>" . $value ."</td>";
              }
            }
            echo  "<td><button class='button remove' value=".$rows['id'].">Remove</button></td>";
          echo "</tr>";
      }
    ?>
  </tbody>
</table>
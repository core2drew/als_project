<?php 
  $query = "SELECT
    CONCAT(lastname, ', ', firstname) as name,
    log_at
    FROM user_logs LEFT JOIN users
    ON user_logs.user_id = users.id
    WHERE users.id = $_GET[user_id] AND users.deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php
  else:
?>
  <table class="table attendance">
    <thead>
      <th>Name</th>
      <th>Date and Time</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $fullname = $row['name'];
          $log_at = $row['log_at'];
          $table_row =
            "<tr>
              <td>$fullname</td>
              <td>$log_at</td>
            </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php
  endif;
?>
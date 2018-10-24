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
      <th>Count</th>
      <th>Date and Time</th>
    </thead>
    <tbody>
      <?php
        $count = 0;
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $fullname = $row['name'];
          $log_at = $row['log_at'];
          $count ++;
          $table_row =
            "<tr>
              <td>$count</td>
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
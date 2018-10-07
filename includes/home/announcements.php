<?php 
  $query= "SELECT a.id, a.title, 
  CONCAT(u.lastname, ', ' , u.firstname) as announcer, a.created_at FROM announcements as a INNER JOIN users as u ON a.user_id = u.id 
  WHERE u.id = $user_id AND a.deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
?>
<div class="table-actions">
  <span id="CreateAnnouncement" class='button'>Create Annoucements</span>
</div>
<table class="table announcements">
  <thead>
    <th>Announcer</th>
    <th>Subject</th>
    <th>Created At</th>
    <th>Options</th>
  </thead>
  <tbody>
    <?php
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $id = $row['id'];
        $announcer = $row['announcer'];
        $title = $row['title'];
        $created_at = $row['created_at'];
        $update = "<span class='button update' data-announcement-id=$id>Update</span>";
        $remove = "<span class='button delete' data-announcement-id=$id>Remove</span>";
        $table_row =
          "<tr>
            <td>$announcer</td>
            <td>$title</td>
            <td>$created_at</td>
            <td class='option'>$update $remove</td>
          </tr>";
        echo $table_row;
      }
    ?>
  </tbody>
</table

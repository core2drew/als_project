<?php 
  $query= "SELECT id, title, description, image_url FROM activities WHERE deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
?>
<div class="table-actions">
  <span id="CreateActivity" class='button'>Create Activity</span>
</div>
<table class="table activities">
  <thead>
    <th>Title</th>
    <th>Description</th>
    <th>Image</th>
    <th class="options">Options</th>
  </thead>
  <tbody>
    <?php
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $id = $row['id'];
        $image_url = $row['image_url'];
        $title = $row['title'];
        $description = $row['description'];
        $image = "<a target='_blank' href=$image_url class='activity'>Preview</a>";
        $update = "<span class='button update' data-activity-id=$id>Update</span>";
        $remove = "<span class='button delete' data-activity-id=$id>Remove</span>";
        $table_row =
          "<tr>
            <td>$title</td>
            <td>$description</td>
            <td>$image</td>
            <td class='option'>$update $remove</td>
          </tr>";
        echo $table_row;
      }
    ?>
  </tbody>
</table>

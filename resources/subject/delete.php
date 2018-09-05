<?php
$is_success = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = isset($_POST['id']) ? $_POST['id'] : null;
  if(isset($id)) {
    $query = "DELETE FROM subjects WHERE id=$id";
    $result = mysqli_query($conn, $query);
    if($result) {
      $is_success = true;
    }
  }
}
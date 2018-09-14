<?php
$is_success = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $deleted_at = date("Y-m-d H:i:s");
  $query = "UPDATE questions SET deleted_at='$deleted_at' WHERE id=$id";
  $result = mysqli_query($conn, $query);

  if($result) {
    $is_success = true;
  }
}


<?php
$is_success = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = isset($_POST['id']) ? $_POST['id'] : null;
  $filename = isset($_POST['filename']) ? $_POST['filename'] : null;
  $deleted_at = date("Y-m-d H:i:s");
  $public_folder = '../../public/videos/';
  
  if(isset($id)) {
    if(!empty($filename)) {
      unlink($public_folder . $filename);
    }
    $query = "UPDATE videos SET deleted_at='$deleted_at' WHERE id=$id";
    $result = mysqli_query($conn, $query);
    if($result) {
      $is_success = true;
    }
  }
}
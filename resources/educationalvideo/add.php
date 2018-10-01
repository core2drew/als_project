<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');
  
  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $upload_option = isset($_POST['upload_option']) ? $_POST['upload_option'] : null;
    $video_url = '';
    $result = '';
    
    //Upload
    if($upload_option === 'upload') {
      $video_filename = $_FILES["video_file"]["name"];
      $file_size = $_FILES['video_file']['size'];
      $tmp_name = $_FILES["video_file"]["tmp_name"];

      $ext = findexts($video_filename); 
      $name = findfilename($video_filename);
      $video_filename = $name.'_'.time().".".$ext;
      $filename = $video_filename;
      move_uploaded_file($tmp_name, "../../public/videos/" . $video_filename);
      $video_url = "/public/videos/" . $video_filename;
    }
    //Link
    if($upload_option === 'link') {
      $filename = NULL;
      $video_url = isset($_POST['video_link']) ? $_POST['video_link'] : null;
    }

    if(isset($upload_option)) {
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
      $video_url = mysqli_real_escape_string($conn, $video_url);
      $created_at = date("Y-m-d H:i:s");
      $upload_option = mysqli_real_escape_string($conn, $upload_option);
      $filename = mysqli_real_escape_string($conn, $filename);
      $query = "INSERT INTO videos (title, subject_id, created_at, url, type, filename) VALUES ('$title', '$subject_id', '$created_at', '$video_url', '$upload_option', '$filename')";
      $result = mysqli_query($conn, $query);
    }
    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);
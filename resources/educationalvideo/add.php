<?php
  $is_success= false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_fields = [];
    $upload_option = $_GET['upload_option'];
    $file_name = $_POST['filename'];

    if(empty($_POST['title'])) {
      $error_fields['title'] = 'Title field is required';
    }
    //Upload
    if($upload_option === 'upload') {
      $file_name = $_FILES["video_file"]["name"];
      $file_size = $_FILES['video_file']['size'];
      $tmp_name = $_FILES["video_file"]["tmp_name"];
      $max_file_size = 100 * 1000000;
      if(empty($file_name)) {
        $error_fields['video_file'] = 'Upload video field is required';
      }
      if ($file_size > $max_file_size) {
        $error_fields['video_file'] = 'This file is larger than 100MB. It must be less than or equal to 100MB';
      }
      if (file_exists("../../public/videos/" . $file_name)) {
        $error_fields['video_file'] = $file_name . " already exists";
      }
    } 
    //Link
    if($upload_option === 'link') {
      if(empty($_POST['video_link'])) {
        $error_fields['video_link'] = 'Video link field is required';
      }
    }

    if(count($error_fields) <= 0) {
      if($upload_option === 'upload') {
        move_uploaded_file($tmp_name, "../../public/videos/" . $file_name);
        $url = "/public/videos/" . $file_name;
      }

      if($upload_option === 'link') {
        $url = $_POST['video_link'];
      }

      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
      $url = mysqli_real_escape_string($conn, $url);
      $created_at = date("Y-m-d H:i:s");
      $upload_option =mysqli_real_escape_string($conn, $upload_option);
      $file_name =mysqli_real_escape_string($conn, $file_name);

      $query = "INSERT INTO videos (title, subject_id, created_at, url, type, filename) VALUES ('$title', '$subject_id', '$created_at', '$url', '$upload_option', '$file_name')";
      $result = mysqli_query($conn, $query);
      if($result) {
        $is_success= true;
      }
    }
  }
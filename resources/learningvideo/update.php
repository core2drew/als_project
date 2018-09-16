<?php

$is_success= false;


if($_SERVER["REQUEST_METHOD"] == "POST") {
  $error_fields = [];
  $upload_option = $_GET['upload_option'];
  $filename = isset($_POST['filename']) ? $_POST['filename'] : null;
  $filename_orig = isset($_POST['filename_orig']) ? $_POST['filename_orig'] : null;
  $url = isset($_POST['url']) ? $_POST['url'] : null;
  $public_folder = '../../public/videos/';
  

  if(empty($_POST['title'])) {
    $error_fields['title'] = 'Title field is required';
  }
  //Upload
  if($upload_option === 'upload') {
    if($filename !== $filename_orig) {
      $filename = $_FILES["video_file"]["name"];
      $file_size = $_FILES['video_file']['size'];
      $tmp_name = $_FILES["video_file"]["tmp_name"];
      $max_file_size = 100 * 1000000;
      if(empty($filename)) {
        $error_fields['video_file'] = 'Upload video field is required';
      }
      if ($file_size > $max_file_size) {
        $error_fields['video_file'] = 'This file is larger than 20MB. It must be less than or equal to 20MB';
      }
      if (file_exists("../../public/videos/" . $filename)){
        $error_fields['video_file'] = $filename . " already exists";
      }
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
      if($filename !== $filename_orig) {
        move_uploaded_file($tmp_name, $public_folder . $filename);
        $url = "/public/videos/" . $filename;
      }
    }

    if($upload_option === 'link') {
      $url = $_POST['video_link'];
      if(isset($filename)) {
        unlink($public_folder . $filename);
        $filename = "";
      }
    }
    
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
    $url = mysqli_real_escape_string($conn, $url);
    $upload_option =mysqli_real_escape_string($conn, $upload_option);
    $filename =mysqli_real_escape_string($conn, $filename);

    $query = "UPDATE videos SET title='$title', subject_id=$subject_id, url='$url', type='$upload_option', filename='$filename' WHERE id=$id";
    $result = mysqli_query($conn, $query);
    if($result) {
      $is_success= true;
    }
  }
}
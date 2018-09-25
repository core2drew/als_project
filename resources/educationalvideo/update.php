<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');
  

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $upload_option = isset($_POST['upload_option']) ? $_POST['upload_option'] : null;
    $video_url = '';
    
    //Upload
    if($upload_option === 'upload') {
      $filename = isset($_POST['filename']) ? $_POST['filename'] : null;
      $current_file_name = isset($_POST['current_file_name']) ? $_POST['current_file_name'] : null;
      $video_url = "/public/videos/" . $current_file_name;

      if($current_file_name !== $filename) {
        $video_filename = $_FILES["video_file"]["name"];
        $file_size = $_FILES['video_file']['size'];
        $tmp_name = $_FILES["video_file"]["tmp_name"];
  
        $ext = findexts($video_filename); 
        $name = findfilename($video_filename);
        $video_filename = $name.'_'.time().".".$ext;
        $filename = $video_filename;//Change filename
        move_uploaded_file($tmp_name, "../../public/videos/" . $video_filename);
        $video_url = "/public/videos/" . $video_filename;
      }
    }
    //Link
    if($upload_option === 'link') {
      $filename = '';
      $video_url = isset($_POST['video_link']) ? $_POST['video_link'] : null;
    }

    if(isset($upload_option)) {
      $id = mysqli_real_escape_string($conn, $_POST['id']);
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $video_url = mysqli_real_escape_string($conn, $video_url);
      $upload_option =mysqli_real_escape_string($conn, $upload_option);
      $filename =mysqli_real_escape_string($conn, $filename);

      $query = "UPDATE videos SET title='$title', url='$video_url', type='$upload_option', filename='$filename' WHERE id=$id";
      $result = mysqli_query($conn, $query);
    }
      
    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);
<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile_image_url = "";

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email_query = "SELECT id FROM users WHERE email='$email' AND deleted_at IS NULL";
    $check_email_result = mysqli_query($conn, $check_email_query);
    $check_email_count = mysqli_num_rows($check_email_result);

    if($check_email_count > 0) {
      $json_data['success'] = false;
      $json_data['message'] = 'Email is already exist';
    } else {
      $tmp_name = $_FILES["profile_image"]["tmp_name"];
      if(!empty($tmp_name)) {
        $ext = findexts($_FILES['profile_image']['name']); 
        $filename = time().".".$ext;
        move_uploaded_file($tmp_name, "../../public/images/profile/" . $filename);
        $profile_image_url = "/public/images/profile/" . $filename;
        $_SESSION['profile_image_url'] = $profile_image_url;
        $profile_image_url = isset($profile_image_url) ? $profile_image_url : null;
      } else {
        $profile_image_url = '/public/images/profile-placeholder-image.png';
      }
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
      $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
      $address = mysqli_real_escape_string($conn, $_POST['address']);
      $contactno = mysqli_real_escape_string($conn, $_POST['contactno']);
      $grade_level = isset($_POST['grade_level']) ? mysqli_real_escape_string($conn, $_POST['grade_level']) : null;
      $teacher_id = isset($_POST['teacher_id']) ? mysqli_real_escape_string($conn, $_POST['teacher_id']) : null;
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $created_at = date("Y-m-d H:i:s");
  
      $query = "INSERT INTO users (lastname, firstname, address, profile_image_url, contactno, grade_level, teacher_id, email, password, type, created_at) VALUES 
      ('$lastname', '$firstname', '$address', '$profile_image_url', '$contactno', '$grade_level', '$teacher_id', '$email', '$password', '$type', '$created_at')";
      $result = mysqli_query($conn, $query);
      
      if($result) {
        $json_data['success'] = true;
      } else {
        $json_data['message'] = 'Oops, something went wrong.';
      }
    }
  }

  echo json_encode($json_data);
<?php 

  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  @ob_start();
  session_id($_POST['session_id']);
  session_start();

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $hasError = false;

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $current_email = mysqli_real_escape_string($conn, $_POST['current_email']);
   
    if($email != $current_email) {
      $check_email_query = "SELECT id FROM users WHERE email='$email' AND deleted_at IS NULL";
      $check_email_result = mysqli_query($conn, $check_email_query);
      $check_email_count = mysqli_num_rows($check_email_result);

      if($check_email_count > 0) {
        $json_data['success'] = false;
        $json_data['message'] = 'Email is already exist';
        $hasError = true;
      }
    }

    if(!$hasError) {
      $tmp_name = $_FILES["profile_image"]["tmp_name"];
      
      $profile_image_url = mysqli_real_escape_string($conn, $_POST['profile_image_url']);

      if(!empty($tmp_name)) {
        $ext = findexts($_FILES['profile_image']['name']); 
        $filename = time().".".$ext;
        move_uploaded_file($tmp_name, "../../public/images/profile/" . $filename);
        $profile_image_url = "/public/images/profile/" . $filename;

        //Update user profile image when updating their own account
        if($_POST['current_user_id'] == $_POST['id']) {
          $_SESSION['profile_image_url'] = $profile_image_url;
        }
      } else {
        $profile_image_url = $_POST['profile_image_url'];
      }
      $_SESSION['fullname'] = $_POST['lastname'] .', '. $_POST['firstname'];

      $id = mysqli_real_escape_string($conn, $_POST['id']);
      $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
      $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
      $address = mysqli_real_escape_string($conn, $_POST['address']);
      $contactno = mysqli_real_escape_string($conn, $_POST['contactno']);
      $profile_image_url = mysqli_real_escape_string($conn, $profile_image_url);
      $teacher_id = isset($_POST['teacher_id']) && !empty($_POST['teacher_id']) ? mysqli_real_escape_string($conn, $_POST['teacher_id']) : null;
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
  
      $query = "UPDATE users SET lastname='$lastname', firstname='$firstname', profile_image_url='$profile_image_url', 
      address='$address', contactno='$contactno', teacher_id='$teacher_id', email='$email', password='$password' WHERE id=$id";
      $result = mysqli_query($conn, $query);

      if($result) {
        $json_data['success'] = true;
      } else {
        $json_data['message'] = 'Oops, something went wrong.';
      }
    }
  }
  session_commit();
  @ob_get_clean();
  echo json_encode($json_data);
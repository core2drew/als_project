<?php 
  $is_success = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_fields = [];
    
    if(empty($_POST['lastname'])) {
      $error_fields['lastname'] = 'Lastname field is required';
    }
  
    if(empty($_POST['firstname'])) {
      $error_fields['firstname'] = 'Firstname field is required';
    }
  
    if(empty($_POST['address'])) {
      $error_fields['address'] = 'Address field is required';
    }
  
    if(empty($_POST['contactno'])) {
      $error_fields['contactno'] = 'Contact No. field is required';
    }
  
    if(empty($_POST['email'])) {
      $error_fields['email'] = 'Email field is required';
    }

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $current_email = mysqli_real_escape_string($conn, $_POST['current_email']);
   
    if($email != $current_email) {
      $check_email_query = "SELECT id FROM users WHERE email='$email' AND deleted_at IS NULL";
      $check_email_result = mysqli_query($conn, $check_email_query);
      $check_email_count = mysqli_num_rows($check_email_result);
      if($check_email_count > 0) {
        $error_fields['email'] = 'Email already exist';
      }
    }

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);

    if($password != $current_password && $password == '') {
      $error_fields['password'] = 'Password field is required';
    }

    if(count($error_fields) <= 0) {
      
      $tmp_name = $_FILES["profile_image"]["tmp_name"];
      if(!empty($tmp_name)) {
        $ext = findexts($_FILES['profile_image']['name']); 
        $filename = time().".".$ext;
        move_uploaded_file($tmp_name, "./public/images/profile/" . $filename);
        $profile_image_url = "/public/images/profile/" . $filename;

        if($_SESSION['user_id'] == $_POST['id']) {
          $_SESSION['profile_image_url'] = $profile_image_url;
        }
      }

      $profile_image_url = isset($profile_image_url) ? $profile_image_url : null;

      $id = mysqli_real_escape_string($conn, $_POST['id']);
      $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
      $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
      $address = mysqli_real_escape_string($conn, $_POST['address']);
      $contactno = mysqli_real_escape_string($conn, $_POST['contactno']);
      $grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
  
      $query = "UPDATE users SET lastname='$lastname', firstname='$firstname', profile_image_url='$profile_image_url', address='$address', contactno='$contactno', 
      email='$email', password='$password' WHERE id='$id'";
      $result = mysqli_query($conn, $query);
      if($result) {
        $is_success = true;
      }
    }
  }


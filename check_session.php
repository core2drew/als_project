<?php
//Checking user session
if(!isset($_SESSION['login_user'])) {
  header("location: /");
}
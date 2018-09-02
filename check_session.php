<?php
//Checking user session
if(!isset($_SESSION['is_logged_in'])) {
  header("location: /");
}
<?php 
  session_start();
  session_destroy();
  header("location:connect_sample.php");
?>
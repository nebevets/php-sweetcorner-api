<?php

  $output = [
    'success' => false
  ];
  $name = null;
  $email = null;
  $password = null;

  if(isset($_POST['name'])){
    $name = $_POST['name'];
  }
  if(isset($_POST['email'])){
    $email = $_POST['email'];
  }
  if(isset($_POST['password'])){
    $password = hash('sha256', $_POST['password']);
  }
  if(!$name || !$email || !$password){
    $output['error'] = 'You must supply name, email, and password.';
  }

  require_once('config.php');

  if(empty($output['error'])){
    $query = "INSERT INTO `users`(`name`, `email`, `password`, `created_at`, `updated_at`) VALUES ('$name','$email','$password',CURRENT_TIME,CURRENT_TIME)";
    $result = mysqli_query($conn, $query);
    if($result && mysqli_affected_rows($conn)){
      $inserted_id = mysqli_insert_id($conn);
      $output['success'] = true;
      $output['user_id'] = $inserted_id;
      $output['message'] = "User successfully created.";
    } else {
      $output['error'] = "There was an error with the query.";
    }
  }

  print json_encode($output);

?>
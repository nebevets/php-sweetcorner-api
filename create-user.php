<?php

  require_once('setup.php');

  $output = [
    'success' => false
  ];
  $name = null;
  $email = null;
  $password = null;

  if(isset($_POST['name'])){
    $name = $_POST['name'];
  } else {
    $output['errors'][] = 'missing name';
  }
  if(isset($_POST['email'])){
    $email = $_POST['email'];
  } else {
    $output['errors'][] = 'missing email';
  }
  if(isset($_POST['password'])){
    $password = hash('sha256', $_POST['password']);
  } else {
    $output['errors'][] = 'missing password';
  }
  
  if(!empty($output['errors'])){
    throw new ApiException($output, 422);
  }

  $query = "INSERT INTO `users`(`name`, `email`, `password`, `created_at`, `updated_at`) VALUES (?,?,?,CURRENT_TIME,CURRENT_TIME)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('sss', $name, $email, $password);

  if($stmt->execute() && $conn->affected_rows){
    $inserted_id = $conn->insert_id;
    $output['success'] = true;
    $output['user_id'] = $inserted_id;
    $output['message'] = "User successfully created.";
  } else {
    throw new ApiException($output, 500, 'There was an error with the query.');
  }

  print json_encode($output);

?>
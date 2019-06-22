<?php

  require_once('setup.php');

  $output = [
    'success' => false
  ];

  $id = null;

  if(isset($_GET['user_id'])){
    $id = $_GET['user_id'];
  } else {
    throw new ApiException($output, 422, 'You must provide a valid user id.');
  }

  $query = "SELECT `id`, `name`, `email`, `created_at`, `updated_at` FROM `users` WHERE `id`=$id";
  $result = $conn->query($query);
  if($result){
    $output['success'] = true;
    $output['user'] = null;
    if($result->num_rows){
      $output['user'] = $result->fetch_assoc();
    } else {
      throw new ApiException($output, 200, "user_id: $id, not found");
    }
  } else {
    throw new ApiException($output, 422, 'There was an error performing the query. Supply a valid user_id');
  }

  print json_encode($output);

?>
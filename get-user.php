<?php

  $output = [
    'success' => false
  ];

  $id = null;

  if(isset($_GET['user_id'])){
    $id = $_GET['user_id'];
  } else {
    $output['error'] = "You must provide a valid user id";
  }

  require_once('config.php');

  if(empty($output['error']) && $id){
    $query = "SELECT `id`, `name`, `email`, `created_at`, `updated_at` FROM `users` WHERE `id`=$id";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      $output['user'] = null;
      if(mysqli_num_rows($result)){
        $output['user'] = mysqli_fetch_assoc($result);
      } else {
        $output['message'] = "user_id: $id, not found";
      }
    } else {
      $output['error'] = "There was an error performing the query";
    }
    
  }

  print json_encode($output);

?>
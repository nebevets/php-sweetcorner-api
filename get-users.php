<?php

  $output = [
    'success' => false
  ];

  require_once('config.php');

  if(empty($output['error'])){
    $query = "SELECT `name`, `email` from `users`";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)){
      while($row = mysqli_fetch_assoc($result)){
        $output['users'][] = $row;
      }
      $output['success'] = true;
    } else {
      $output['error'] = 'No users found';
    }
  }

  print json_encode($output);

?>
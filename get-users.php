<?php

  $output = [
    'success' => false
  ];

  require_once('config.php');

  if(empty($output['error'])){
    $query = "SELECT `id`, `name`, `email` from `users`";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      if(mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
          $output['users'][] = $row;
        }
      } else {
        $output['users'] = [];
      }
    } else {
      $output['error'] = "There was an error performing the query";
    }
    
  }

  print json_encode($output);

?>
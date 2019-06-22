<?php

  require_once('setup.php');

  $output = [
    'success' => false
  ];

  $user_id = null;

  if(isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];
  }else{
    throw new ApiException($output, 400, 'A user_id is required for creating a cart.');
  }
  
  $query = "INSERT INTO `cart` (`user_id`, `created_at`, `updated_at`) VALUES ( two , CURRENT_TIME , CURRENT_TIME );";
  $result = $conn->query($query);
  if($result){
    $output['success'] = true;
    $output['message'] =  'Cart created successfully';
    $output['cart_id'] = $conn->insert_id;
  } else {
    $error = $conn->error;
    if($error === ''){
      $error = "There was an error performing the query.";
    }
    throw new ApiException($output, 500, $error);
  }
  
  print json_encode($output);

?>

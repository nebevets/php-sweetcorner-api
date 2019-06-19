<?php

  $output = [
    'success' => false
  ];

  $user_id = null;

  if(isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];
    require_once('config.php');
  }else{
    $output['error'] = "A user_id is required for creating a cart";
  }
  
  if(empty($output['error'])){
    $query = "INSERT INTO `cart` (`user_id`, `created_at`, `updated_at`) VALUES ( $user_id , CURRENT_TIME , CURRENT_TIME );";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      $output['message'] =  'Cart created successfully';
      $output['cart_id'] = mysqli_insert_id($conn);
    } else {
      $error = mysqli_error($conn);
      if($error !== ''){
        $output['error'] = $error;  
      } else {
        $output['error'] = "There was an error performing the query.";
      }
    }
  }
  
  print json_encode($output);

?>

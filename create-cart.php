<?php
// Remember to set created at and updated at to current time
// Creates a new cart
// On success, success => true, message => 'Cart created successfully', cart_id => 2
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
    echo 'connected to database<br>';
    echo "user_id is $user_id<br>";
    $query = "INSERT INTO `cart` (`user_id`, `created_at`, `updated_at`) VALUES ( $user_id , CURRENT_TIME , CURRENT_TIME );";
    print($query);
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      $output['message'] =  'Cart created successfully';
      $output['cart_id'] = mysqli_insert_id($conn);
    } else {
      $output['error'] = "There was an error performing the query.";
    }
  }
  
  print json_encode($output);

?>

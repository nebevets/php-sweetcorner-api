<?php

  require_once('setup.php');

  $output = [
    'success' => false
  ];

  $cart_id = null;
  $product_id = null;

  if(isset($_POST['cart_id'])){
    $cart_id = $_POST['cart_id'];
    if(isset($_POST['product_id'])){
      $product_id = $_POST['product_id'];
      $quantity = 1;
      if(isset($_POST['quantity'])){
        $quantity = (int) $_POST['quantity'];
        if($quantity < 1){
          $quantity = 1;
        }
      }
    } else {
      throw new ApiException($output, 400, 'A product_id is required for creating a cart.');
    }
  } else {
    throw new ApiException($output, 400, 'A cart_id is required for creating a cart.');
  }

  $query = "INSERT INTO `cart_items`(`cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES ($cart_id,$product_id,$quantity,CURRENT_TIME,CURRENT_TIME);";
  $result = $conn->query($query);
  if($result){
    $output['success'] = true;
    $output['message'] =  "$quantity item(s) added to cart";
    //$output['cart_item_id'] = $conn->insert_id;
    $output['cart_id'] = $cart_id;
  } else {
    $error = $conn->error;
    if($error === ''){
      $output['error'] = "There was an error performing the query.";
    }
    throw new ApiException($output, 500, $error);
  }

  print json_encode($output);

?>

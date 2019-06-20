<?php
// METHOD POST
// GETS a Cart id and product id via POST
// and quantity via POST if no quantity default to 1
// Remember to set created at and updated at to current time
// Creates a new cart item
// On success, success => true, message => 'item added to cart', cart_id => 2

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
      require_once('config.php');
    } else {
      $output['error'] = "A product_id is required for creating a cart";
    }
  } else {
    $output['error'] = "A cart_id is required for creating a cart";
  }

  if(empty($output['error'])){
    $query = "INSERT INTO `cart_items`(`cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES ($cart_id,$product_id,$quantity,CURRENT_TIME,CURRENT_TIME);";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      $output['message'] =  "$quantity item(s) added to cart";
      $output['cart_item_id'] = mysqli_insert_id($conn);
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

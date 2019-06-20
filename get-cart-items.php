<?php 

  $output = [
    'success' => false
  ];

  $cart_id = null;

  if(isset($_GET['cart_id'])){
    $cart_id = $_GET['cart_id'];
    require_once('config.php');
  } else {
    $output['error'] = "You must provide a valid user cart_id.";
  }
  if(empty($output['error'])){
    $query = "SELECT
        p.name,
        p.cost,
        ci.quantity,
        i.file_path AS src,
        i.alt_text AS alt,
        c.user_id,
        ci.cart_id,
        ci.product_id
    FROM `cart` AS c
    JOIN `cart_items` AS ci
      ON c.id = ci.cart_id
    JOIN `products` AS p
      ON ci.product_id = p.id
    JOIN `images` AS i
      ON p.image_id = i.id
    WHERE c.id = $cart_id";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      $output['cartItems'] = [];
      if(mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
          $output['cartItems'][] = [
            'product_name' => $row['name'],
            'product_cost' => (int) $row['cost'],
            'cart_item_quantity' => (int) $row['quantity'],
            'image' => [
                'src' => $row['src'],
                'alt' => $row['alt']
            ],
            'user_id' => (int) $row['user_id'],
            'cart_id' => (int) $row['cart_id'],
            'product_id' => (int) $row['product_id']
          ];
        }
      }
    } else {
      $output['error'] = "There was an error performing the query. Be sure to supply a valid cart_id";
    }
  }

  print json_encode($output);

?>

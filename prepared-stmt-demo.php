<?php
  
  require_once('setup.php');

  $stmt = $conn->prepare('INSERT INTO `products`(`name`, `description`, `cost`, `image_id`, `created_at`, `updated_at`) VALUES (?,?,?,?,CURRENT_TIME,CURRENT_TIME);');

  $name = 'Sookie';
  $description = 'Red Velvet cake with fairy dust topping.';
  $cost = 777;
  $image_id = 2;

  $stmt->bind_param('ssii', $name, $description, $cost, $image_id);

  $stmt->execute();

  print 'products added.';

?>
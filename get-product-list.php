<?php

  $output = [
    'success' => false
  ];
  $id = null;
  require_once('config.php');
  if(empty($_GET['id'])){
    $output['error'] = "You must specify an id.";
  }else{
    $id = $_GET['id'];
  }
  if(empty($output['error'])){
    $query = "SELECT
                p.id,
                p.name,
                p.description,
                p.cost,
                i.alt_text AS alt,
                i.caption AS title,
                i.file_path AS src
              FROM products AS p
              JOIN images AS i
              ON p.image_id = i.id
              WHERE i.id = $id";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      if(mysqli_num_rows($result)){
        $output['products'] = [];
        while($row = mysqli_fetch_assoc($result)){
          $product = [
            'image' => []
          ];
          foreach($row as $key => $value){
            switch ($key) {
              case 'alt':
              case 'title':
              case 'src':
                $product['image'][$key] = $value; 
                  break;
              default:
                $product[$key] = $value;
            }
          }
          $output['products'][] = $product;
        }
      } else {
        $output['products'] = [];
      }
    } else {
      $output['error'] = "There was an error performing the query";
    }
  }

  print json_encode($output);
 
?>
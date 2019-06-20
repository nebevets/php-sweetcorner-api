<?php

  $output = [
    'success' => false
  ];

  $id = null;

  if(empty($_GET['id'])){
    $output['error'] = "You must specify an id.";
  } else {
    $id = $_GET['id'];
    require_once('config.php');
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
              WHERE p.id = $id";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      if(mysqli_num_rows($result)){
        $output['products'] = [];
        if(mysqli_num_rows($result)){
          while($row = mysqli_fetch_assoc($result)){
            $output['products'][] = [
              'id' => (int) $row['id'],
              "name" => $row['name'],
              "description" => $row['description'],
              "cost" => (int) $row['cost'],
              'image' => [
                'alt' => $row['alt'],
                'title' => $row['title'],
                'src' => $row['src'],
              ]
            ];
          }
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
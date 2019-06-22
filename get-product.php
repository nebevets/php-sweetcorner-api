<?php

  require_once('setup.php');

  $output = [
    'success' => false
  ];

  $id = null;

  if(empty($_GET['id'])){
    throw new ApiException($output, 422, 'You must specify an id.');
  } else {
    $id = $_GET['id'];
  }
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
  $result = $conn->query($query);
  if($result){
    $output['success'] = true;
    if($result->num_rows){
      if($result->num_rows){
        $row = $result->fetch_assoc();
          $output['product'] = [
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
    } else {
      $output['product'] = [];
      throw new ApiException($output, 500, "No product was found for product id: $id");
      // 204 as a status code works, but does not return our output data
    }
  } else {
    throw new ApiException($output, 422, 'There was an error performing the query.');
  }

  print json_encode($output);
 
?>
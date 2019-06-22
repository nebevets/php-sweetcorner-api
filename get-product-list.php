<?php

  require_once('setup.php');

  $output = [
    'success' => false
  ];

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
            ON p.image_id = i.id";
  $result = $conn->query($query);
  if($result){
    $output['success'] = true;
    if($result->num_rows){
      while($row = $result->fetch_assoc()){
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
    } else {
      $output['products'] = [];
      throw new ApiException($output, 500, 'No products found.');
    }
  } else {
    throw new ApiException($output, 500, 'There was an error performing the query.');
  }

  print json_encode($output);
 
?>
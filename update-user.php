<?php

  $output = [
    'success' => false,
  ];
  
  $updates = [];

  if(empty($_GET['id'])){
    $output['error'] = "You must specify a user id.";
  }else{
    $id = $_GET['id'];
  }
  if(isset($_POST['name'])){
    $updates['name'] = $_POST['name'];
  }
  if(isset($_POST['email'])){
    $updates['email'] = $_POST['email'];
  }
  if(isset($_POST['password'])){
    $updates['password'] = hash('sha256', $_POST['password']);
  }
  if(!count($updates)){
    $output['error'] = "You must supply a name, email, or password to update.";
  }

  require_once('config.php');

  if(empty($output['error'])){
    $set = 'SET ';
    foreach ($updates as $key => $value) {
      $set = $set."`$key` = '$value',";
    }
    $set = $set." `updated_at`=CURRENT_TIME ";
    $query = "update `users` $set where `id`=$id;";
    $result = mysqli_query($conn, $query);
    if($result){
      $output['success'] = true;
      $keys = '';
      if(mysqli_affected_rows($conn)){
        foreach($updates as $key => $value){
          $keys = $keys.$key.", ";
        }
        $keys = rtrim(trim($keys), ',');
        $output['message'] = "$keys set for id: $id.";
      } else {
        $output['message'] = "Nothing was updated for user id: $id.";
      }
    } else {
      $output['error'] = "There was an error performing the query.";
    }
  }

  print json_encode($output);

?>

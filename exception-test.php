<?php

require_once('error-handler.php');

$value = $_GET['value'];

try{
  if($value > 1){
    throw new Exception('The value was greater than 1...Run!');
  } else {
    throw new ApiException([], 402, 'the value is too small');
  }
}
// custom classes need to come before their ancestors
catch(ApiException $ex) {
  $ex->send_error();
}
catch(Exception $ex) {
  print 'the exception was: '.$ex->getMessage();
}

?>
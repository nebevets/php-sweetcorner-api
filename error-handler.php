<?php

class ApiException extends Exception {
  private $output;

  public function __construct($output = [], $code = 500, $message = 'fubar', Exception $previous = null){
    $this->output = $output;
    parent::__construct($message, $code, $previous); // construct is a static method
  }
  public function send_error(){
    if(empty($this->output['error']) && empty($this->output['errors'])){
      $this->output['error'] = $this->message;
    }
    http_response_code($this->code);
    print json_encode($this->output);
    die();
  }
}

function defaultExceptionHandler($ex){
  $ex->send_error();
}

set_exception_handler('defaultExceptionHandler');

?>
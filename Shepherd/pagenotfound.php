<?php

class PageNotFound extends View {

  function __construct() {

    parent::__construct();
    new httpResponse( 'Not Found' );
    $this->_template = '404';
    
  }

}
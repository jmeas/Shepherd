<?php

class PageNotFound extends View {

  function __construct() {

    parent::__construct();
    new httpHeaderResponse( 'Not Found' );
    $this->_template = '404';
    
  }

}
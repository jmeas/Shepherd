<?php

class PageNotFound extends View {

  public function __construct( $url ) {
    parent::__construct( $url );
    new httpResponseCode( 'Not Found' );
    $this->_template = '404';
  }

}
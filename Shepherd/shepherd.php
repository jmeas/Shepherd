<?php

class Shepherd {

  function __construct() {
    
    // Loads your site's URLs
    if ( file_exists('../../' . Config::PROJECT_NAME . '/urls.php') )
      require_once( '../../' . Config::PROJECT_NAME . '/urls.php' );
    else {
      //Throw a Shepherd error if Config::DEBUG
    }
  }

}
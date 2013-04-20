<?php

class Shepherd {

  function __construct() {
    
    // Loads your site's URLs
    if ( file_exists('../../' . Config::SITE_NAME . '/urls.php') )
      require_once( '../../' . Config::SITE_NAME . '/urls.php' );

  }

}
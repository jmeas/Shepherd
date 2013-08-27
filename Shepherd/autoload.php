<?php

// Initiate a new web request
new WebRequest();

// Autoload our classes
function __autoload( $class ) {

  // Config file
  if ( $class === 'Config' && file_exists('../../Config.php') )
    require_once( '../../Config.php' );

  // Your app's URLs
  else if ( $class === 'Urls' && file_exists('../../' . Config::PROJECT_NAME . '/urls.php') )
    require_once( '../../' . Config::PROJECT_NAME . '/urls.php' );

  // Shepherd base classes
  else if ( file_exists(strtolower($class) . '.php') )
    require_once( strtolower($class) . '.php' );

  // Your app's views
  else if ( file_exists('../../' . Config::PROJECT_NAME . '/' . Config::VIEWS_DIRECTORY . '/' . strtolower($class) . '.php') )
    require_once( '../../' . Config::PROJECT_NAME . '/' . Config::VIEWS_DIRECTORY . '/' . strtolower($class) . '.php' );

  // Your app's utils
  else if ( file_exists('../../' . Config::PROJECT_NAME . '/' . Config::UTILS_DIRECTORY . '/' . strtolower($class) . '.php') )
    require_once( '../../' . Config::PROJECT_NAME . '/' . Config::UTILS_DIRECTORY . '/' . strtolower($class) . '.php' );

}
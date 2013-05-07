<?php

// Loads shepherd up

new Shepherd();

// Automatically load classes

function __autoload( $class ) {

  // Loads shepherd classes

  // Config file
  if ( $class === 'Config' && file_exists('../../Config.php') )
    require_once( '../../Config.php' );

  // Shepherd base classes
  else if ( file_exists(strtolower($class) . '.php') )
    require_once( strtolower($class) . '.php' );

  // Shepherd utils
  else if ( file_exists('utils/' . strtolower($class) . '.php') )
    require_once( 'utils/' . strtolower($class) . '.php' );

  // Your app's urls
  else if ( $class === 'Urls' && file_exists('../../' . Config::PROJECT_NAME . '/urls.php') )
    require_once( '../../' . Config::PROJECT_NAME . '/urls.php' );

  // Your app's views
  else if ( file_exists('../../' . Config::PROJECT_NAME . '/' . Config::VIEWS_DIRECTORY . '/' . strtolower($class) . '.php') )
    require_once( '../../' . Config::PROJECT_NAME . '/' . Config::VIEWS_DIRECTORY . '/' . strtolower($class) . '.php' );
}

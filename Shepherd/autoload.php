<?php

// Loads shepherd up

new Shepherd();

// Automatically load classes

function __autoload( $class ) {

  // Loads shepherd classes

  if ( file_exists(strtolower($class) . '.php') )
    require_once( strtolower($class) . '.php' );

  else if ( file_exists('utils/' . strtolower($class) . '.php') )
    require_once( 'utils/' . strtolower($class) . '.php' );

  else if ( file_exists('../../' . strtolower($class) . '.php') )
    require_once( '../../' . strtolower($class) . '.php' );

  // Loads your app's base classes

  else if ( file_exists('../../' . Config::PROJECT_NAME . '/' . strtolower($class) . '.php') )
    require_once( '../../' . Config::PROJECT_NAME . '/' . strtolower($class) . '.php' );

  // Loads your app's views

  else if ( file_exists('../../' . Config::PROJECT_NAME . '/' . Config::VIEWS_DIRECTORY . '/' . strtolower($class) . '.php') )
    require_once( '../../' . Config::PROJECT_NAME . '/' . Config::VIEWS_DIRECTORY . '/' . strtolower($class) . '.php' );
}

<?php

// Loads shepherd up

new Shepherd();

// Automatically load classes

function __autoload( $class ) {

  // Loads shepherd classes

  if ( file_exists(strtolower($class) . '.php') )
    require_once( strtolower($class) . '.php' );

  else if ( file_exists('tools/' . strtolower($class) . '.php') )
    require_once( 'tools/' . strtolower($class) . '.php' );

  else if ( file_exists('../../' . strtolower($class) . '.php') )
    require_once( '../../' . strtolower($class) . '.php' );

  // Loads your app's base classes

  else if ( file_exists('../../' . CONFIG::SITE_NAME . '/' . strtolower($class) . '.php') )
    require_once( '../../' . CONFIG::SITE_NAME . '/' . strtolower($class) . '.php' );

  // Loads your app's views

  else if ( file_exists('../../' . CONFIG::SITE_NAME . '/views//' . strtolower($class) . '.php') )
    require_once( '../../' . CONFIG::SITE_NAME . '/views//' . strtolower($class) . '.php' );
}

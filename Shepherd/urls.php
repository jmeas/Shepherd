<?php

// This class manages routing URLs

class Urls {

  private $_host;                   // The protocol and host; i.e., http://example.com
  private $_appUrls;                // An array of URLs and the view they correspond to
  private $_view;                   // This URL's view
  private $_pointsToFile = false;   // Whether this URL corresponds to a file or not
  private $_fileServer;             // The object that can serve a file for this URL
  public static $url;                    // The location; i.e., people/brianj

  function __construct( $appUrls ) {

    $host = 'http://'.$_SERVER[HTTP_HOST];          // Scope this
    $url = ltrim( $_SERVER['REQUEST_URI'], '/' );   // This, too
    
    $this->_host = $host;
    Urls::$url = strtok( $url, '?' );
    $this->_appUrls = $appUrls;
    $this->_fileServer = new FileServer( Urls::$url );
    $this->_pointsToFile = $this->_fileServer->fileExists();

    $this->handleURL();

  }

  function handleURL() {

    if ( !$this->_pointsToFile )
      $this->checkForMatchingPattern();
    else {
      $this->_fileServer->serveFile();
      exit();
    }

  }

  // Determines if the request matches a URL pattern

  function checkForMatchingPattern() {

    $this->_view = 'pagenotfound';

    foreach( $this->_appUrls as $regex => $view ) {

      //Tries to find a match
      preg_match_all( $regex, Urls::$url, $match );

      $matchedurl = implode( '',$match[0] );          // Scope this

      if ( $matchedurl == Urls::$url ) {
        $this->_view = $view;
        break;
      }
    }
    
  }

  function __destruct() {
    if ( !$this->_pointsToFile && class_exists($this->_view) )
      new $this->_view( 'soda' );
  }

}
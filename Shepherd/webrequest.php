<?php

class WebRequest {

  private $_url;
  private $_fileServer;
  private $_servingFile = false;
  private $_appUrls;
  private $_view;
  private $_fileLocations;
  private $_fileLocation;
  
  public function __construct() {
    date_default_timezone_set('UTC');
    $this->parseUrl();
    $this->_fileLocations = $this->fileLocations();
    $this->_servingFile   = $this->fileExists();
    $this->_appUrls       = $this->loadAppUrls();
    $this->_view          = $this->checkIfView();
  }

  private function parseUrl() {
    $this->_url = ltrim( $_SERVER['REQUEST_URI'], '/' );
    // This strips out the base directory if the request isn't to the root domain
    if (substr($this->_url, 0, strlen(Config::BASE_URL)) == Config::BASE_URL)
      $this->_url = substr($this->_url, strlen(Config::BASE_URL));
    $this->_url = parse_url( $this->_url, PHP_URL_PATH );
  }

  private function fileLocations() {
    $locations = array();
    // Handles STATIC_DIRECTORY and MEDIA_DIRECTORY file locations
    array_push($locations, '../../' . strtolower(Config::PROJECT_NAME) . Config::STATIC_DIRECTORY . '/' . $this->_url);
    array_push($locations, '../../' . strtolower(Config::PROJECT_NAME) . Config::MEDIA_DIRECTORY  . '/' . $this->_url);
    return $locations;
  }

  private function fileExists() {
    foreach($this->_fileLocations as &$location) {
      if (file_exists( $location ) && is_file( $location )) {
        $this->_fileLocation = $location;
        return true;
      }
    }
    return false;
  }

  private function loadAppUrls() {
    $urlLocation = '../../' . Config::PROJECT_NAME . '/urls.json';
    if ( file_exists($urlLocation) && is_file($urlLocation) )
      return json_decode( file_get_contents($urlLocation), true );
    else
      return false;
  }

  private function checkIfView() {
    if ( $this->_appUrls !== false ) {
      foreach( $this->_appUrls as $object => $urlData ) {
        preg_match_all( $urlData['pattern'], $this->_url, $match );
        $matchedurl = implode( '', $match[0] );
        if ( $matchedurl == $this->_url )
          return $urlData['view'];
      }
    }
    return 'pagenotfound';
  }

  public function __destruct() {
    // Serves file or loads the view
    if ( $this->_servingFile ) {
      $this->_fileServer = new FileServer( $this->_fileLocation );
    } else if ( $this->_view !== false )
        new $this->_view( $this->_url );
  }
}
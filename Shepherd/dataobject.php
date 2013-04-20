<?php

// This class is quite seriously a work-in-progress.

class DataObject {

  private $_jsonString;
  private $_location;
  private $_sourceCount;
  public $exists = false;
  public $query;

  function __construct($location, $query='', $sourceCount='single') {

    $this->query = $query;
    $this->_location = $location;
    $this->_sourceCount=$sourceCount;

    $this->exists = $this->doesThisExists();

    if ($this->_sourceCount == 'single')
      $this->grabSingleSourceData();
    if ($this->_sourceCount == 'multiple')
      $this->grabMultipleSourceData();

  }

  private function doesThisExist() {
    if ($this->_sourceCount == 'single') {

    }
    else if ($this->_sourceCount == 'multiple') {

    }
    return false;
  }

  private function setVariables() {

    if ()
    $fullName = $this->query . '.json';

    $agnosticName = '../../' . strtolower(Config::SITE_NAME) . Config::DATA_URL . '/' . $this->_location . $this->query;

    if (file_exists($agnosticName.".json") || file_exists($agnosticName.".xml"))
      echo '{ "name": "yes" }';
    else
      echo '{ "name": "'.$agnosticName.'.json" }';
    
    //if (file_exists('../../' . strtolower(Config::SITE_NAME) . Config::DATA_URL . '/' . $this->_location . $this->name)) {

    

    /*$di = new RecursiveDirectoryIterator('../../' . strtolower(Config::SITE_NAME) . Config::DATA_URL . '/' . $this->_location);

    foreach ( new RecursiveIteratorIterator($di) as $filename => $file ) {
      if ( $fullName == basename($filename) ) {

        $this->_jsonString = file_get_contents($filename);
        $this->_jsonObject = json_decode($this->_jsonString, true);
        $this->exists = true;
        return;

      }
    }*/
    //$this->exists = false;
  }

  public static function getByObject($fileName, $objectName) {

    /*$jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator($this->_jsonString),
        RecursiveIteratorIterator::SELF_FIRST);

      foreach ($jsonIterator as $key => $val) {

        if(is_array($val)) {

          if ($user === $val['-id'] && $semisecure === $val['password']) {
            Authentication::saveCookie();
            return true;
          }
        }
      }*/

  }

  public static function getByValues($fileName, $matchArray) {

  }

  public static function writeFile($fileName, $data) {

  }

}
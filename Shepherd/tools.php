<?php

class Tools {

  public static function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
  }

}
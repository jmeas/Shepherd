<?php

class httpResponseCode {

  private $_httpResponses = array(
    'Continue' => '100',
    'Switching Protocols' => '101',
    'OK' => '200',
    'Created' => '201',
    'Accepted' => '202',
    'Non-Authoritative Information' => '203',
    'No Content' => '204',
    'Reset Content' => '205',
    'Partial Content' => '206',
    'Multiple Choices' => '300',
    'Moved Permanently' => '301',
    'Moved Temporarily' => '302',
    'See Other' => '303',
    'Not Modified' => '304',
    'Use Proxy' => '305',
    'Bad Request' => '400',
    'Unauthorized' => '401',
    'Payment Required' => '402',
    'Forbidden' => '403',
    'Not Found' => '404',
    'Method Not Allowed' => '405',
    'Not Acceptable' => '406',
    'Proxy Authentication Required' => '407',
    'Request Time-out' => '408',
    'Conflict' => '409',
    'Gone' => '410',
    'Length Required' => '411',
    'Precondition Failed' => '412',
    'Request Entity Too Large' => '413',
    'Request-URI Too Large' => '414',
    'Unsupported Media Type' => '415',
    'Internal Server Error' => '500',
    'Not Implemented' => '501',
    'Bad Gateway' => '502',
    'Service Unavailable' => '503',
    'Gateway Time-out' => '504',
    'HTTP Version not supported' => '505',
  );

  // Sets the response header
  public function __construct( $response ) {
    if ( array_key_exists($response, $this->_httpResponses) ) {
      $protocol = ( isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' );
      header( $protocol . ' ' . $this->_httpResponses[$response] . ' ' . $response );
    }
  }

}
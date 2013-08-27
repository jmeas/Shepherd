<?php

class View {

  protected $_method;     // The HTTP request method accessing the view
  protected $_ajaxMethod; // The method to respond to AJAX requests with
  protected $_template;   // The template to use
  protected $_ajax;       // A boolean representing whether or not this is an AJAX request
  protected $_url;
  protected $_params;

  public function __construct( $url ) {
    session_start();
    $this->_params      = new Params();  // For PUT and DELETE variables
    $this->_method      = $this->setMethod();
    $this->_ajaxMethod  = $this->_method."_AJAX";
    $this->_ajax        = $this->isThisAjax();
    $this->_url         = $url;
  }

  private function setMethod() {
    if ( $_SERVER['REQUEST_METHOD'] == 'GET' )
      return 'GET';
    else if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
      return 'POST';
    else if ( $_SERVER['REQUEST_METHOD'] == 'DELETE' )
      return 'DELETE';
    else if ( $_SERVER['REQUEST_METHOD'] == 'PUT' )
      return 'PUT';
  }

  private function isThisAjax() {
    if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
      return true;
    else
      return false;
  }

  // The default responses
  protected function GET()     { new httpResponseCode( 'OK' );        }
  protected function POST()    { new httpResponseCode( 'Forbidden' ); }
  protected function DELETE()  { new httpResponseCode( 'Forbidden' ); }
  protected function PUT()     { new httpResponseCode( 'Forbidden' ); }

  public function __destruct() {
    if ( $this->_ajax && method_exists($this, $this->_ajaxMethod) )
      $this->{$this->_ajaxMethod}();
    else
      $this->{$this->_method}();
    if ( !$this->_ajax && !Tools::isNullOrEmptyString( $this->_template) )
      new Render( $this->_template, array() );
  }

}
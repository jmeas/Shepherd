<?php

class View {

  
  protected $_method;   // The HTTP request method accessing the view
  protected $_template; // The template to use
  protected $_ajax;     // A boolean representing whether or not this is an AJAX request
  protected $_loginRequired = false;
  protected $_url;
  protected $_loggedIn = false;
  public static $data;

  function __construct() {

    session_start();

    $this->_method = $this->setMethod();
    $this->_ajax = $this->isThisAjax();
    View::$data = array();
    $this->_loggedIn = Authentication::loggedIn();

  }

  function setMethod() {

    if ( $_SERVER['REQUEST_METHOD'] == 'GET' )
      return 'GET';
    else if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
      return 'POST';
    else if ( $_SERVER['REQUEST_METHOD'] == 'DELETE' )
      return 'DELETE';
    else if ( $_SERVER['REQUEST_METHOD'] == 'PUT' )
      return 'PUT';

  }

  function isThisAjax() {

    if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
      return true;
    else
      return false;

  }

  // The default responses

  function GET()    { new httpResponse( 'OK' );        }

  function POST()   { new httpResponse( 'Forbidden' ); }

  function DELETE() { new httpResponse( 'Forbidden' ); }

  function PUT()    { new httpResponse( 'Forbidden' ); }

  protected function iShouldRender() {
    if ( !Tools::isNullOrEmptyString( $this->_template) && !$_this->ajax )
      return true;
    return false;
  }
  protected function isPermitted() {
    if ( $this->_loginRequired && $this->_loggedIn )
      return true;
    else if ( !$this->_loginRequired )
      return true;
    return false;
  }

  function __destruct() {

    if ( $this->isPermitted() )
    {
      $ajaxMethodName = $this->_method . '_Ajax';
      if ( $this->_ajax && method_exists($this, $ajaxMethodName) )
        $this->{$ajaxMethodName}();
      else
        $this->{$this->_method}();

    }
    else {
      $_SESSION['redirectUrl'] = Urls::$url;
      header( 'Location:'.$host.'/'.Config::LOGIN_URL );
    }

    if ( $this->iShouldRender() )
      new Render( $this->_template, View::$data );

  }

}
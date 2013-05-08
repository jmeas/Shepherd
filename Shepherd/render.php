<?php

class Render {

  private $_loader;
  private $_page;
  private $_template;
  private $_data;

  function __construct( $template, $data ) {

    $this->_template = $template;
    $this->_data = $data;

    // Loads Twig
    require_once '../Twig/Autoloader.php';
    Twig_Autoloader::register();

    $templateDir = '../../'.strtolower( Config::PROJECT_NAME ).Config::TEMPLATES_DIRECTORY;

    if ( file_exists($templateDir) && is_dir($templateDir) ) {
      $this->_loader = new Twig_Loader_Filesystem( $templateDir );
      $this->_page = new Twig_Environment( $this->_loader );
    }
    else {
      // Error, no template directory
    }

  }

  function __destruct() {


    if ( $this->_template != '' ) {
      $this->_page->display( $this->_template.'.html', $this->_data );
      exit();
    }
  }

}
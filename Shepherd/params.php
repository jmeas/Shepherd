<?php

// Adds support for PUT and DELETE variables
class Params {

  private $params = Array();

  public function __construct() {
    $this->parseParams();
  }

  public function get($name, $default = null) {
    if (isset($this->params[$name]))
      return $this->params[$name];
    else
      return $default;
  }

  private function parseParams() {
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "PUT" || $method == "DELETE") {
        parse_str(file_get_contents('php://input'), $this->params);
        $GLOBALS["_{$method}"] = $this->params;
        // Add these request vars into _REQUEST, mimicing default behavior, PUT/DELETE will override existing COOKIE/GET vars
        $_REQUEST = $this->params + $_REQUEST;
    } else if ($method == "GET") {
        $this->params = $_GET;
    } else if ($method == "POST") {
        $this->params = $_POST;
    }
  }
}
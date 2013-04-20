<?php

class Authentication {

  public static function loginRequired() {
    
    $_SESSION['redirectUrl'] = Urls::$url;
    if (!Authentication::loggedIn()) {
      $redirect = $host.'/'.Config::LOGIN_URL;
      header("Location: $redirect");
    }
  }

  public static function authenticate() {
    if (Authentication::loggedIn() || Authentication::validated()) {
      return true;
    }
    return false;
    //return (Authentication::loggedIn() || Authentication::validated()) ? true : false;
  }

  public static function logout() {
    if (isset($_COOKIE['HARMONY_LOGIN'])) {
      setcookie("HARMONY_LOGIN", '', time()-999999); // Destroys the cookie
    }
  }

  public static function loggedIn() {

    if (isset($_COOKIE['HARMONY_LOGIN'])) {

      $cookieData = explode('::', $_COOKIE['HARMONY_LOGIN']);
      $cookieUser = $cookieData[0];
      $cookieHash = $cookieData[1];

      if (file_exists("../../".Config::SITE_NAME."/data/users/persistence/{$cookieUser}.json")) {

        $json = file_get_contents("../../".Config::SITE_NAME."/data/users/persistence/{$cookieUser}.json");
        $jsonPhp = json_decode($json);

        if (isset($jsonPhp->key) && $jsonPhp->key == $cookieHash) {
            View::$data['user'] = $cookieUser;
            return true;
        }
      }
    }
    return false;
  }

  private static function validated() {

    if (isset($_POST['inputUser']) && isset($_POST['inputPassword'])) {

      $user = $_POST['inputUser'];
      $password = $_POST['inputPassword'];

      if ($user === '' || $password === '') {
        return false;
      }

      return Authentication::authenticator();

    }
    else {
      return false;
    }
  }

  private function validCredentials($secureString) {

    if (file_exists("../../".Config::SITE_NAME."/data/users/users.json")) {

      $json = file_get_contents("../../".Config::SITE_NAME."/data/users/users.json");
      $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($json, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

      foreach ($jsonIterator as $key => $val) {

        if(is_array($val)) {

          if ($user === $val['-id'] && $semisecure === $val['password']) {
            Authentication::saveCookie();
            return true;
          }
        }
      }
    }
    return false;
  }

  private static function authenticator() {

    $remember = isset($_POST['remember']) ? true : false;

    $user = $_POST['inputUser'];
    $password = $_POST['inputPassword'];
    $semisecure = crypt(md5($password),md5($user));

    if (file_exists("../../".Config::SITE_NAME."/data/users/users.json")) {

      $json = file_get_contents("../../".Config::SITE_NAME."/data/users/users.json");
      $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($json, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

      foreach ($jsonIterator as $key => $val) {

        if(is_array($val)) {

          if ($user === $val['-id'] && $semisecure === $val['password']) {
            Authentication::saveCookie();
            return true;
          }
        }
      }
    }
    return false;
  }

  private static function saveCookie() {

    $remember = isset($_POST['remember']) ? true : false;

    $user = $_POST['inputUser'];
    $password = $_POST['inputPassword'];
    $dateTime = time();
    $timedHash = crypt(md5($password),md5($dateTime.'pasta'));
    $cookieValue = $user.'::'.$timedHash;

    if ($remember) // Sets a cookie that expires in 20 years
      setcookie("HARMONY_LOGIN", $cookieValue, time()+(20 * 365 * 24 * 60 * 60));
    else // Sets a cookie that expires at the end of the session
      setcookie("HARMONY_LOGIN", $cookieValue, 0);

    // This saves your persistence to the database
    $jsonString = '{ "key" : "'.$timedHash.'" }';

    file_put_contents("../../".Config::SITE_NAME."/data/users/persistence/{$user}.json", $jsonString);


  }

  


}
<?php

namespace Src\Controllers;
use Src\Helper\GoogleAuthClient;
use Src\Helper\Common;

class Login
{

  public function __construct()
  {
    return $this;
  }

  /**
   * Index page
   * @return $this
   */
  public function indexAction(): Login
  {
    return $this;
  }
  public function processLoginAction()
  {
    $googleAuth = new GoogleAuthClient();
    $loginUrl = $googleAuth->getLoginAuth();
    header('Location: ' . $loginUrl);
    exit();
  }
  public function authcallbackAction(){
    $googleAuth = new GoogleAuthClient();
    // Get profile info from Google
    $userInfo = $googleAuth->getUserInfo();
    if (!empty($userInfo)) {
      $_SESSION['user_email'] = $userInfo['email'];
      $_SESSION['user_name'] = $userInfo['name'];
      $_SESSION['access_token'] = $userInfo['accessToken'];
      $commonHelper = new Common();
      $commonHelper->internalRedirect('home');
    }
    else{
      $commonHelper = new Common();
      $commonHelper->internalRedirect('login');
    }
  }
}
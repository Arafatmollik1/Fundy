<?php

namespace Src\Controllers;
use Src\Helper\GoogleAuthClient;
use Src\Helper\Common;
use Src\Helper\Login as loginHelper;

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
      $loginHelper = new loginHelper();
      $validate = $loginHelper->validateLogin($userInfo);
      if($validate){
        $setToDatabase = $loginHelper->setToDatabase($userInfo);
        if($setToDatabase){
          $_SESSION['user_email'] = $userInfo['email'];
          $_SESSION['user_name'] = $userInfo['name'];
          $_SESSION['access_token'] = $userInfo['accessToken'];
          $_SESSION['user_reference_number'] = $loginHelper->getUserRefNo();
          $commonHelper = new Common();
          $commonHelper->internalRedirect('home');
        }
      }
    }
    $commonHelper = new Common();
    $commonHelper->internalRedirect('login');
  }
}
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
  public function processLoginWithGoogleAction()
  {
    $googleAuth = new GoogleAuthClient();
    $loginUrl = $googleAuth->getLoginAuth();
    header('Location: ' . $loginUrl);
    exit();
  }
  public function processLoginWithEmailAction(){
    if(!empty($_POST['name']) && !empty($_POST['email'])){
      $userInfo['name'] = trim($_POST['name']);
      $emailLowerCase = strtolower($_POST['email']);
      $userInfo['email'] = preg_replace('/\s+/', '', $emailLowerCase);
      $userInfo['loginMethod'] = 'email';
    }
    if (!empty($userInfo)) {
      $loginHelper = new loginHelper();
      $validate = $loginHelper->validateLogin($userInfo);
      if($validate){
        $loginHelper->setLoginMethod($userInfo['loginMethod']);
        $setToDatabase = $loginHelper->setToDatabase($userInfo);
        if($setToDatabase){
          $_SESSION['user_email'] = $userInfo['email'];
          $_SESSION['user_name'] = $userInfo['name'];
          $_SESSION['user_reference_number'] = $loginHelper->getUserRefNo();
          $_SESSION['user_fund_id'] = $loginHelper->getUserFundId();
          $commonHelper = new Common();
          $commonHelper->internalRedirect('home');
        }
      }
    }
    $commonHelper = new Common();
    $commonHelper->internalRedirect('login');
  }
  public function authcallbackAction(){
    $googleAuth = new GoogleAuthClient();
    // Get profile info from Google
    $userInfo = $googleAuth->getUserInfo();
    if (!empty($userInfo)) {
      $loginHelper = new loginHelper();
      $validate = $loginHelper->validateLogin($userInfo);
      if($validate){
        $loginHelper->setLoginMethod($userInfo['loginMethod']);
        $setToDatabase = $loginHelper->setToDatabase($userInfo);
        if($setToDatabase){
          $_SESSION['user_email'] = $userInfo['email'];
          $_SESSION['user_name'] = $userInfo['name'];
          $_SESSION['access_token'] = $userInfo['accessToken'];
          $_SESSION['user_reference_number'] = $loginHelper->getUserRefNo();
          $_SESSION['user_fund_id'] = $loginHelper->getUserFundId();
          $commonHelper = new Common();
          $commonHelper->internalRedirect('home');
        }
      }
    }
    $commonHelper = new Common();
    $commonHelper->internalRedirect('login');
  }
}
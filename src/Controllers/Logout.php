<?php

namespace Src\Controllers;
use Src\Helper\GoogleAuthClient;
use Src\Helper\Common;

class Logout {
    public function __construct() {
        return $this;
    }
    public function indexAction()
    {
        return $this;
    }
    public function logoutAction(){
        $googleAuth = new GoogleAuthClient();

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $googleAuth->revokeToken($_SESSION['access_token']);
        }
        unset($_SESSION);
        $commonHelper = new Common();
        $commonHelper->internalRedirect('logout/index');
        exit();
    }

}
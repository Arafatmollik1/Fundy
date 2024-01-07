<?php

namespace Src\Controllers;
use  Src\Helper\Common;


class Home {

  public function __construct() {
    return $this;
  }

  /**
   * Index page
   * @return $this
   */
  public function indexAction() {
    $requiredKeys = ['user_email', 'user_name', 'user_reference_number'];
    foreach ($requiredKeys as $key) {
        if (!isset($_SESSION[$key]) || empty($_SESSION[$key])) {
          $commonHelper = new Common();
          $commonHelper->internalRedirect('logout/logout');
        }
    }
    return $this;
  }

}
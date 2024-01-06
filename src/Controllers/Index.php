<?php

namespace Src\Controllers;
use Src\Utility\SqlBuilder;
use Src\Helper\Common;

class Index {

  public function __construct() {
    return $this;
  }

  /**
   * Index page
   * @return $this
   */
  public function indexAction(): Index
  {
    $commonHelper = new Common();
    $commonHelper->internalRedirect('login');
    return $this;
  }
  /**
   * For Unit testing
   */
  public function getUserInfo($tablename) { 
    $result = (new SqlBuilder)->read("*")->from($tablename)->execute();
    return $result;
  }

}
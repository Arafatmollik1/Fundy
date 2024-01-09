<?php

namespace Src\Controllers;
use  Src\Helper\Common;
use Src\Helper\Home as HomeHelper;

class Home {
  public string $paymentStatus;
  public string $postHeader;
  public string $postSubHeader;
  public string $imageURL;
  public int $confirmedParticipants = 0;
  public array $allParticipants;

  public function __construct() {
    return $this;
  }

  /**
   * Index page
   * @return $this
   */
  public function indexAction() {
    $homeHelper = new HomeHelper();
    $homeHelper->validate();
    $setPostContent = $homeHelper->setPostContentsFromDb();
    if(!$setPostContent){
      $commonHelper = new Common();
      $commonHelper->internalRedirect('logout/logout');
    }
    $postContents = $homeHelper->getPostContents();
    $this->postHeader = $postContents['header'];
    $this->postSubHeader = $postContents['subheader'];
    $this->imageURL = $postContents['image_URL'];
    $this->paymentStatus = $homeHelper->getPaymentStatus();
    $this->confirmedParticipants = $homeHelper->getConfirmedParticipants();
    $this->allParticipants = $homeHelper->getAllParticipantsInfo();
    return $this;
  }
  public function setpaymentinfoAction(){
    $homeHelper = new HomeHelper();
    $homeHelper->validate();
    $homeHelper->setPayment();
    $homeHelper->setAllParticipantsTickets();
    $commonHelper = new Common();
    $commonHelper->internalRedirect('home');
  }

}
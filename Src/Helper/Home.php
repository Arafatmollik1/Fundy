<?php
namespace Src\Helper;
use Src\Utility\SqlBuilder;

class Home
{
    public array $postContents;
    public array $paymentInfo;
    private int $participantCount;
    private array $confirmedParticipants;
    public string $paymentId;

    public function __construct(){

    }
    public function validate() : void
    {
        $requiredKeys = ['user_email', 'user_name', 'user_reference_number'];
        foreach ($requiredKeys as $key) {
          if (!isset($_SESSION[$key]) || empty($_SESSION[$key])) {
            $commonHelper = new Common();
            $commonHelper->internalRedirect('logout/logout');
          }
        }
    }
    public function setPostContentsFromDb() : bool
    {
        $crudify = new SqlBuilder();
        $config = \Config\Config::getInstance()->config;
        $postId = $config->fundInfo['post_id'];
        $postContents = $crudify->read('*')->from('post_contents')->where("post_id='$postId'")->execute();
        if(count($postContents) > 0 ){
            $this->postContents = $postContents[0];
            return  true;
        }
        return  false;
    }
    public function getPostContents() : array 
    {
        return $this->postContents;
    }
    public function getPaymentStatus() : string
    {
        $crudify = new SqlBuilder();
        $refId = $_SESSION['user_reference_number'];
        $payments = $crudify->read('*')->from('payments')->where("ref_id='$refId'")->execute();
        return count($payments) > 0 ? $payments[0]['payment_status'] : 'none';
    }
    public function setPayment() : void
    {
        $crudify = new SqlBuilder();
            $refId = $_SESSION['user_reference_number'];
            $usersInfo = $crudify->read('*')->from('users')->where("ref_id='$refId'")->execute();
            $participantInfo = $this->getParticipantInfo();
            $participantNo = $this->getParticipantNo();
            $this->paymentId = rand(100000, 999999);
            $insert = [
                'payment_id' => $this->paymentId,
                'user_id' => $usersInfo[0]['user_id'],
                'ref_id' => $usersInfo[0]['ref_id'],
                'email' => $usersInfo[0]['email'],
                'name' => $_POST['payersName'],
                'phone_no' => $_POST['payersPhone'],
                'participant_no' => $participantNo,
                'participant_info' => json_encode($participantInfo),
                'payment_amount' => $_POST['paymentAmount'],
                'payment_status	' => 'pending',
                'payment_time' => date("Y-m-d H:i:s"),

            ];
            $crudify->create($insert)->from('payments')->execute();
    }
    public function setAllParticipantsTickets() : void
    {
        $crudify = new SqlBuilder();
        $refId = $_SESSION['user_reference_number'];
        $participantInfo = $this->getParticipantInfo();
        foreach($participantInfo['adult'] as $participant){
            $insert = [
                'ticket_id' =>  $this->paymentId,
                'name' => $participant,
                'email' => '',
                'payment_status' => 'pending',
                'is_checked_in' => 0,
                'payers_ref_id' => $refId,
                'payers_name' => $_SESSION['user_name'],
            ];
            $crudify->create($insert)->from('tickets')->execute();
        }
        foreach($participantInfo['child'] as $participant){
            $insert = [
                'ticket_id' =>  $this->paymentId,
                'name' => $participant,
                'email' => '',
                'payment_status' => 'pending',
                'is_checked_in' => 0,
                'payers_ref_id' => $refId,
                'payers_name' => $_SESSION['user_name'],
            ];
            $crudify->create($insert)->from('tickets')->execute();
        }
    }
    protected function getParticipantNo() : int
    {
        $adultCount = 0;
        $childCount = 0;
        $postData = $_POST;
    
        // Iterate over each key in the $_POST array
        foreach (array_keys($postData) as $key) {
            // Check if the key contains 'newAdult'
            if (strpos($key, 'newAdult') !== false) {
                $adultCount++;
            }
    
            // Check if the key contains 'newChild'
            if (strpos($key, 'newChild') !== false) {
                $childCount++;
            }
        }
        return $adultCount + $childCount ;

    }
    protected function getParticipantInfo() : array
    {
        $participantInfo = ['adult' => [], 'child' => []];
        $postData = $_POST;
    
        // Iterate over each key in the $_POST array
        foreach ($postData as $key => $value) {
            // Check if the key contains 'newAdult'
            if (strpos($key, 'newAdult') !== false) {
                $participantInfo['adult'][] = $value; 
            }
    
            // Check if the key contains 'newChild'
            if (strpos($key, 'newChild') !== false) {
                $participantInfo['child'][] = $value;  
            }
        }
        return $participantInfo;

    }
    public function getConfirmedParticipants() : int
    {
        $crudify = new SqlBuilder();
        $refId = $_SESSION['user_reference_number'];
        $result = $crudify->read('*')->from('tickets')->where("payers_ref_id='$refId'")->execute();
        $this->confirmedParticipants = $result;
        return count($result);
    }
    public function getAllParticipantsInfo() : array 
    {
        return $this->confirmedParticipants;
    }

}
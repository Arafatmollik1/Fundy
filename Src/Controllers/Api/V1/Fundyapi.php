<?php

namespace Src\Controllers\Api\V1;
use Src\Utility\SqlBuilder;

class Fundyapi {

    public function __construct() {
        return $this;
    }
    public function setpaymentAction($getParamas, $postParams, $jsonData){
        $paymentStatus = '';
        $data = '';
        if(!isset($getParamas['ref']) || !isset($getParamas['status'])){
            $data = 'Please send value for ref(users reference number) and status(c/p)';
        }

        $userRef = $getParamas['ref'];
        if($getParamas['status'] = 'c'){
            $paymentStatus = 'confirmed';
        }
        elseif($getParamas['status'] = 'p'){
            $paymentStatus = 'pending';
        }
        else{
            $paymentStatus = 'none';
        }
        $crudify = new SqlBuilder();
        $update = [
          'payment_status' => $paymentStatus,
        ];
        $result = $crudify->update($update)->from('payments')->where("ref_id='$userRef'")->execute();
        if($result ){
            $updateTickets = [
                'payment_status	' => $paymentStatus,
            ];
            $result = $crudify->update($updateTickets)->from('tickets')->where("payers_ref_id='$userRef'")->execute();
            if($result){
                $data= [
                    'Text' =>'Payment status for ref number '. $userRef .' is updated',
                ];
            }else{
                $data = 'Something went wrong.';
            }
        }
        else{
            $data = 'Something went wrong.';
        }
        return $data;
    }
}

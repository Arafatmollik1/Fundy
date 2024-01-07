<?php
namespace Src\Helper;
use Src\Utility\SqlBuilder;


class Login
{
    public object $crudify;
    protected int $userId;
    protected $loginTime;
    protected string $fundId;
    protected string $refId;
    private string $loginMethod;
    public function __construct()
    {

    }
    public function validateLogin( array $userInfo): bool
    {
        $requiredKeys = ['email', 'name', 'loginMethod'];
        foreach ($requiredKeys as $key) {
            if (!isset($userInfo[$key]) || empty($userInfo[$key])) {
                return false;
            }
        }
        return true;
    }
    public function generateUserRefNo(array $userInfo): string
    {
        $fundID = $this->getUserFundId();
        $name = preg_replace('/\s+/', '', $userInfo['name']);
        $randomDigits = rand(1000, 9999);
        $userRefNo = strtoupper($fundID) . strtoupper($name) . $randomDigits;

        return $userRefNo;
    }
    public function getUserFundId() : string
    {
        $config = \Config\Config::getInstance()->config;
        $fundId = $config->fundInfo['id'];
        return $fundId;
    }
    public function getUserRefNo() : string
    {
        return $this->refId;
    }
    public function setLoginMethod( string $method) : void{
        $this->loginMethod = $method;
    }
    public function getLoginMethod() : string{
        return $this->loginMethod;
    }
    public function setToDatabase(array $userInfo) : bool
    {
        $this->crudify = new SqlBuilder();
        $currentUserInfo = $this->checkIfUserAlreadyInDB($userInfo['email']);
        $insertLoginInfo = $this->insertLoginInfoToDB($currentUserInfo, $userInfo);
        if($insertLoginInfo){
            $insertuserInfo = $this->insertuserInfoToDB($currentUserInfo, $userInfo);
            return $insertuserInfo;
        }
        return false;
    }
    public function checkIfUserAlreadyInDB( string $email) : array
    {
        $param = trim($email);
        $result = $this->crudify->read('*')->from('users')->where("email='$param'")->execute();
        return $result;
    }
    public function insertLoginInfoToDB( array $currentUserInfo, array $userInfo) : bool
    {
        $this->userId = rand(100000, 999999);
        $loginId = rand(100000, 999999);
        $this->loginTime = date("Y-m-d H:i:s");
        if(count($currentUserInfo) > 0 && isset($currentUserInfo[0]['user_id'])){
            $this->fundId = $currentUserInfo[0]['fund_id'];
            $this->refId = $currentUserInfo[0]['ref_id'];
            $insertToUsersLogin = [
                'login_id' => $loginId,
                'user_id' => $currentUserInfo[0]['user_id'],
                'fund_id' => $currentUserInfo[0]['fund_id'],
                'ref_id' => $currentUserInfo[0]['ref_id'],
                'login_method' => $this->getLoginMethod(),
                'login_time'  =>  $this->loginTime,
                'session_id' => session_id()
            ];
        } else{
            $this->fundId = $this->getUserFundId();
            $this->refId = $this->generateUserRefNo($userInfo);
            $insertToUsersLogin = [
                'login_id' => $loginId,
                'user_id' => $this->userId,
                'fund_id' => $this->fundId,
                'ref_id' => $this->refId,
                'login_method' => $this->getLoginMethod(),
                'login_time'  =>  $this->loginTime,
                'session_id' => session_id()
            ];
        }
        $result = $this->crudify->create($insertToUsersLogin)->from('user_login')->execute();
        return $result;

    }
    public function insertuserInfoToDB( array $currentUserInfo, array $userInfo) : bool{
        if(count($currentUserInfo) > 0 && isset($currentUserInfo[0]['user_id'])){
            $updateUsers = [
                'last_login' => $this->loginTime,
            ];
            $param = trim($userInfo['email']);
            $result = $this->crudify->update($updateUsers)->from('users')->where("email='$param'")->execute();
            return $result;
        }
        $insertToUsers = [
            'user_id' => $this->userId,
            'name' => $userInfo['name'],
            'email' => $userInfo['email'],
            'fund_id' => $this->fundId,
            'ref_id' => $this->refId,
            'last_login' => $this->loginTime,
        ];
        $result = $this->crudify->create($insertToUsers)->from('users')->execute();
        return $result;
    }

}
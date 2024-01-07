<?php
namespace Src\Helper;
use Google_Client;
use Google_Service_Oauth2;
use Src\Utility\DebugLogger;

class GoogleAuthClient
{
    private object $client;
    private string $email;
    private string $name;
    private string $accessToken;
    public function __construct()
    {
        try{
            $this->setClient();
        }catch(\Exception $e){
            $logger = new DebugLogger();

            $logger->logWarning('Starting google client failed. More info: '. $e->getMessage());
            $commonHelper = new Common();
            $commonHelper->internalRedirect('login');
            exit();
        }
    }
    private function setClient(){
        $config = \Config\Config::getInstance()->config;
        $client = new Google_Client();
        $client->setClientId($config->auth['google_auth']['client_id']);
        $client->setClientSecret($config->auth['google_auth']['client_secret']);
        $client->setRedirectUri($config->auth['google_auth']['redirect_url']);
        $client->addScope("email");
        $client->addScope("profile");
        $this->client = $client;
    }
    public function getClient(){
        return $this->client;
    }
    public function getLoginAuth(){
        return $this->client->createAuthUrl();
    }
    private function setUserInfo(){
        $client = $this->client;

        if (isset($_GET['code'])) {
            try{
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($token);
                $this->accessToken = $token['access_token'];

                // Get profile info from Google
                $google_oauth = new Google_Service_Oauth2($client);
                $google_account_info = $google_oauth->userinfo->get();

                $this->email = $google_account_info->email;
                $this->name = $google_account_info->name;
            }catch(\Exception $e){
                $logger = new DebugLogger();
                $logger->logWarning('Starting Google Service Oauth failed and failed to set name and email. More info: '. $e->getMessage());
                $commonHelper = new Common();
                $commonHelper->internalRedirect('login');
            }
            
        }else{
            $logger = new DebugLogger();
            $logger->logWarning('No code in the get parameter was found for setting user info from google client');
            $commonHelper = new Common();
            $commonHelper->internalRedirect('login');
        }
    }
    public function getUserInfo(){
        $this->setUserInfo();
        if(isset($this->email) && isset($this->name) && isset($this->accessToken)){
            $info =  [ 
                    'email' => $this->email,
                    'name' => $this->name,
                    'accessToken' => $this->accessToken,
                    'loginMethod' => 'google',
                ];
            return $info;
        }
        return [];
    }
    public function revokeToken($token){
        $client = $this->client;
        $client->revokeToken($token);
    }
}
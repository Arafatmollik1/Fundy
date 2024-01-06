<?php
namespace Src\Helper;


class Login
{
    public function __construct()
    {

    }
    public function validateLogin($userInfo): bool
    {
        $requiredKeys = ['email', 'name', 'accessToken'];
        foreach ($requiredKeys as $key) {
            if (!isset($userInfo[$key]) || empty($userInfo[$key])) {
                return false;
            }
        }
        return true;
    }
    public function generateUserRefNo($userInfo): array
    {
        $config = \Config\Config::getInstance()->config;
        $fundID = $config->fundInfo['id'];
        $name =  preg_replace('/\s+/', '', $userInfo['name']);
        $randomDigits = rand(1000, 9999); 

        $userRefNo = strtoupper($fundID) . strtoupper($name) . $randomDigits;

        return ['refNo' => $userRefNo];
    }

}
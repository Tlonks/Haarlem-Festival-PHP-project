<?php

require_once __DIR__."/../repositories/LoginRepository.php";
require_once __DIR__."/../services/MailService.php";

class PasswordResetService
{
    private $loginRepository;
    private $mailService;

    function __construct()
    {
        $this->loginRepository = new LoginRepository();
        $this->mailService = new MailService();
    }

    public function sendCode($email,$code)
    {
        $this->mailService->sendMail($email,$code);
    }

    public function randomCode()
    {
        $code = rand(100000, 999999);
        return $code;
    }

    public function resetPassword($password,$email)
    {
        $this->loginRepository->changePassword($password,$email);
    }

}
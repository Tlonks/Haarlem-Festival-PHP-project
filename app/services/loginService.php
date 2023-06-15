<?php
require_once __DIR__ . "/../repositories/LoginRepository.php";
require_once __DIR__ . "/../repositories/PictureRepository.php";
class loginService
{
    private $loginRepository;
    private $pictureRepository;

    function __construct()
    {
        $this->loginRepository = new LoginRepository();
        $this->pictureRepository = new PictureRepository();
    }

    public function getUser($username)
    {
        return $user = $this->loginRepository->getUser($username);
    }

    public function getAllUsers()
    {
        return $users = $this->loginRepository->getAllUsers();
    }

    public function uploadUser($user)
    {
        $this->loginRepository->uploadUser($user);
    }
    //Haalt alles opnieuw op en zet het in de sessie
    public function refreshUser($username)
    {
        unset($_SESSION["user"]);
        unset($_SESSION["userPicture"]);
        unset($_SESSION["Role"]);
        $user = $this->getUser($username);
        $_SESSION["user"] = $user;
        $userPicture = $this->pictureRepository->getPicture($user["userId"]);
        $_SESSION["userPicture"] = "data:image/jpeg;base64," . base64_encode($userPicture["picture"]);
        $_SESSION["Role"] = $user["role"];
    }

    public function getUserById(mixed $id)
    {
        return $this->loginRepository->getUserById($id);
    }

    public function updateUserAdmin(mixed $userId, mixed $firstName, mixed $lastName, mixed $email, mixed $phoneNumber, mixed $role, mixed $password)
    {
        $this->loginRepository->updateUserAdmin($userId, $firstName, $lastName, $email, $phoneNumber, $role, $password);
    }

    public function deleteUser(mixed $id)
    {
        $this->loginRepository->deleteUser($id);
    }


}

?>
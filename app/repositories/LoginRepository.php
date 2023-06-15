<?php
require_once __DIR__."/../models/user.php";
require_once __DIR__."/repository.php";

class LoginRepository extends Repository
{

    public function getUser($username)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Users WHERE email= :Email");
        $stmt->bindParam(':Email', $username);
        $stmt->execute();
        
        $stmt->setFetchMode(PDO::FETCH_CLASS,'user');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllUsers()
    {
        $stmt = $this->connection->prepare("SELECT * FROM Users");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,'user');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function uploadUser($user)
    {
        $password = password_hash($user->hashedPassword, PASSWORD_DEFAULT);

        $stmt = $this->connection->prepare("INSERT INTO Users (userId, firstName,
        lastName, role, email, hashedPassword, pictureId, phoneNumber, registrationDate,
        cartId) VALUES (null, :Firstname, :Lastname, :Role, :Email, :Password, null,
        :Phonenumber, NOW(), :cartId)");
        $stmt->bindParam(':Firstname', $user->firstName);
        $stmt->bindParam(':Lastname', $user->lastName);
        $stmt->bindParam(':Email', $user->email);
        $stmt->bindParam(':Password', $password);
        $stmt->bindParam(':Role', $user->role);
        $stmt->bindParam(':Phonenumber', $user->phoneNumber);
        $stmt->bindParam(':cartId', $user->cartId);

        $stmt->execute();
    }

    public function updateUser($userEmail, $firstName, $lastName, $email, $password)
    {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("UPDATE Users SET firstName = :Firstname, lastName = :Lastname, email = :Email, hashedPassword = :Password WHERE email = :UserId");
        $stmt->bindParam(':Firstname', $firstName);
        $stmt->bindParam(':Lastname', $lastName);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Password', $passwordHashed);
        $stmt->bindParam(':UserId', $userEmail);
        $stmt->execute();
    }

    public function updateUserAdmin($userId, $firstName, $lastName, $email, $phonenumber, $role, $password)
    {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->connection->prepare("UPDATE Users SET firstName = :Firstname, lastName = :Lastname, email = :Email, phoneNumber = :PhoneNumber, role = :Role, hashedPassword = :HPassword WHERE userId = :UserId");
        $stmt->bindParam(':Firstname', $firstName);
        $stmt->bindParam(':Lastname', $lastName);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Role', $role);
        $stmt->bindParam(':PhoneNumber', $phonenumber);
        $stmt->bindParam(':UserId', $userId);
        $stmt->bindParam(':HPassword', $passwordHashed);
        $stmt->execute();
    }

    public function updateUserWithoutPassword($userEmail, $firstName, $lastName, $email)
    {
        $stmt = $this->connection->prepare("UPDATE Users SET firstName = :Firstname, lastName = :Lastname, email = :Email WHERE email = :UserId");
        $stmt->bindParam(':Firstname', $firstName);
        $stmt->bindParam(':Lastname', $lastName);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':UserId', $userEmail);
        $stmt->execute();
    }

    public function changePassword($password,$email)
    {
        
        $stmt = $this->connection->prepare("UPDATE Users SET hashedPassword = :Password WHERE email = :Email");
        $stmt->bindParam(':Password', $password);
        $stmt->bindParam(':Email', $email);
        $stmt->execute();
    }

    public function deleteUser($id){
        $stmt = $this->connection->prepare("DELETE FROM Users WHERE userId = :Id");
        $stmt->bindParam(':Id', $id);
        $stmt->execute();
    }

    public function updateToken($id,$key)
    {
        $encryptToken = password_hash($key, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("UPDATE Users SET apiKey = :Token WHERE userId = :Id");
        $stmt->bindParam(':Token', $encryptToken);
        $stmt->bindParam(':Id', $id);
        $stmt->execute();
    }

    public function deleteToken($id)
    {
        $stmt = $this->connection->prepare("UPDATE Users SET apiKey = null WHERE userId = :Id");
        $stmt->bindParam(':Id', $id);
        $stmt->execute();
    }

    public function getApiToken($id)
    {
        $stmt = $this->connection->prepare("SELECT apiKey FROM Users WHERE userId = :Id");
        $stmt->bindParam(':Id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['apiKey'];
    }

    public function checkExistingEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Users WHERE email = :Email");
        $stmt->bindParam(':Email', $email);
        $stmt->execute();
        $result = $stmt->fetch();
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }

    public function getUserById(mixed $id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Users WHERE userId = :Id");
        $stmt->bindParam(':Id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,'user');
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
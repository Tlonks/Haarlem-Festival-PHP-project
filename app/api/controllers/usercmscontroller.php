<?php
include_once __DIR__ . "/../../services/loginService.php";
include_once __DIR__ . '/apicontroller.php';

class usercmscontroller extends apicontroller
{
    private loginService $loginService;

    function __construct()
    {
        parent::__construct();
        $this->loginService = new loginService();
    }

    // router maps this to /api/cms automatically
    public function index()
    {
        if ($this->checkKey()){
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Create a new Event object using the data from the array
                require_once __DIR__ . "/../../repositories/ShoppingCartRepository.php";
                $repository = new ShoppingCartRepository();

                $user = new User();
                $user->firstName = ($data["firstName"]);
                $user->lastName = ($data["lastName"]);
                $user->email = ($data["email"]);
                $user->role = ($data["role"]);
                $user->phoneNumber = ($data["phoneNumber"]);
                $user->hashedPassword = ($data["password"]);
                $user->registrationDate = ($data["registrationDate"]);
                $user->cartId = $repository->createShoppingCart();

                // Insert the event into the database
                $this->loginService->uploadUser($user);
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        // Respond to a GET request to /api/cms
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $id = $_GET['userId'];

            $result = $this->loginService->getUserById($id);

            header('Content-Type: application/json');
            echo json_encode($result);
        }

        // Respond to a POST request to /api/cms
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Insert the danceEvent into the database
                $this->loginService->updateUserAdmin($data["userId"], $data["firstName"], $data["lastName"], $data["email"], $data["phoneNumber"], $data["role"], $data["password"]);
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
                return;
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header('Content-Type: application/json');
            $id = $_GET['userId'];
            // Insert the danceEvent into the database
            try {
                $this->loginService->deleteUser($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {

                echo 'Caught exception: ', $e->getMessage();
            }


        }
    }
}
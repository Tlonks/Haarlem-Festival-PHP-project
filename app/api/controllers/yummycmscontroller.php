<?php
include_once __DIR__ . '/../../services/YummyService.php';
include_once __DIR__ . '/../../models/YummyContentCards.php';
include_once __DIR__ . '/apicontroller.php';
class yummycmscontroller extends apicontroller
{

    private YummyService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new YummyService();
    }

    public function index(){
        if ($this->checkKey()){
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $restaurant = new YummyContentCards();
                $restaurant->title = $_POST['title'];
                $restaurant->page = 'Yummy';
                $restaurant->stars = $_POST['stars'];
                $restaurant->price = $_POST['price'];
                $restaurant->duration = $_POST['duration'];
                $restaurant->typeOfFood = $_POST['typeOfFood'];
                $restaurant->location = $_POST['location'];

                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $restaurant->id = $id;
                }

                //check if the picture field was sent in the request
                if (isset($_FILES['picture'])) {
                    // Read the file data
                    $picture = file_get_contents($_FILES['picture']['tmp_name']);
                    // Set the picture data
                    $restaurant->image = $picture;
                }

                if (isset($_POST['id'])){
                    $this->service->updateRestaurant($restaurant);
                }else{
                    $this->service->addRestaurant($restaurant);
                }


            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header('Content-Type: application/json');
            $id = $_GET['yummyId'];

            $result = $this->service->getContentCardById($id);

            echo json_encode($result);
        }

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header('Content-Type: application/json');
            $id = $_GET['yummyId'];

            try {
                $this->service->deleteRestaurant($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                echo 'Caught exception: ' .  $e->getMessage();
            }
        }
    }
}
<?php

include_once __DIR__ . '/../../services/VenueService.php';
include_once __DIR__ . '/apicontroller.php';

class venuecmscontroller extends apicontroller
{
    private VenueService $venueService;

    function __construct()
    {
        parent::__construct();
        $this->venueService = new VenueService();
    }

    public function index()
    {
        if ($this->checkKey()){
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $venue = new Venue();
                $venue->name = $_POST['name'];;
                $venue->description = $_POST['description'];
                $venue->location = $_POST['location'];

                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $venue->id = $id;
                }

                //check if the picture field was sent in the request
                if (isset($_FILES['picture'])) {
                    // Read the file data
                    $picture = file_get_contents($_FILES['picture']['tmp_name']);
                    // Set the picture data
                    $venue->picture = $picture;
                }

                if (isset($_POST['id'])){
                    $this->venueService->updateVenue($venue);
                }else{
                    $this->venueService->addVenue($venue);
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
            $id = $_GET['venueId'];

            $result = $this->venueService->getVenueById($id);

            echo json_encode($result);
        }

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header('Content-Type: application/json');
            $id = $_GET['venueId'];

            try {
                $this->venueService->deleteVenue($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                echo 'Caught exception: ' .  $e->getMessage();
            }
        }
    }
}
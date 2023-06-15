<?php

include_once __DIR__ . '/../../services/HistoryService.php';
include_once __DIR__ . '/apicontroller.php';

class HistorySightsCmsController extends apicontroller
{
    private HistoryService $service;

    function __construct()
    {
        parent::__construct();
        $this->service = new HistoryService();
    }

    public function index()
    {
        if ($this->checkKey()){
            return;
        }

        // Respond to a GET request to /api/cms
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header('Content-Type: application/json');
            $id = $_GET['sightId'];

            $result = $this->service->getSightById($id);

            echo json_encode($result);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $sight = new ContentCards();
                $sight->title = $_POST['title'];
                $sight->information = $_POST['information'];
                $sight->page = 'History';

                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $sight->id = $id;
                }

                //check if the picture field was sent in the request
                if (isset($_FILES['picture'])) {
                    // Read the file data
                    $picture = file_get_contents($_FILES['picture']['tmp_name']);
                    // Set the picture data
                    $sight->image = $picture;
                }

                if (isset($_POST['id'])){
                    $this->service->updateSight($sight);
                }else{
                    $this->service->addSight($sight);
                }


            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header('Content-Type: application/json');
            $id = $_GET['sightId'];
            // Insert the danceEvent into the database
            try {
                $this->service->deleteSight($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage();
            }
        }

    }

}
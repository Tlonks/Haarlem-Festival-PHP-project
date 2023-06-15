<?php

include_once __DIR__ . '/../../services/eventService.php';
include_once __DIR__ . '/apicontroller.php';

class jazzcmscontroller extends apicontroller
{
    private eventService $eventService;

    function __construct()
    {
        parent::__construct();
        $this->eventService = new eventService();
    }

    // router maps this to /api/cms automatically
    public function index()
    {
        if ($this->checkKey()){
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Create a new Event object using the data from the array
                require_once __DIR__ . "/../../models/JazzEvent.php";
                $event = new JazzEvent();
                $event->name = ($data["name"]);
                $event->date = ($data["date"]);
                $event->endTime = ($data["endTime"]);
                $event->price = ($data["price"]);
                $event->quantity = ($data["quantity"]);
                $event->location = ($data["location"]);
                $event->hall = ($data["hall"]);
                $event->artistId = ($data["artist"]);

                // Insert the event into the database
                $this->eventService->addTypeOfEvent($event, 'jazz');
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => "error:" . $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET"){
            header('Content-Type: application/json');
            $id = $_GET['eventId'];

            $result = $this->eventService->getJazzEventById($id);

            echo json_encode($result);
        }

        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Insert the danceEvent into the database
                $this->eventService->updateJazzEvent($data);
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);

        }

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header('Content-Type: application/json');
            $id = $_GET['eventId'];
            // Insert the danceEvent into the database
            try {
                $this->eventService->deleteJazzEvent($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage();
            }
        }
    }
}

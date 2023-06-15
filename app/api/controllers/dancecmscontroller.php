<?php

include_once __DIR__ . '/../../services/eventService.php';
include_once __DIR__ . '/apicontroller.php';

class dancecmscontroller extends apicontroller
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Create a new Event object using the data from the array
                $event = new DanceEvent();
                $event->name = ($data["name"]);
                $event->date = ($data["date"]);
                $event->price = ($data["price"]);
                $event->quantity = ($data["quantity"]);
                $event->setLocation($data["location"]);
                $event->setArtist($data["artist"]);
                $event->setSession($data["session"]);

                // Insert the event into the database
                $this->eventService->addTypeOfEvent($event, 'dance');
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        // Respond to a GET request to /api/cms
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header('Content-Type: application/json');
            $id = $_GET['eventId'];

            $result = $this->eventService->getDanceEventById($id);

            echo json_encode($result);
        }

        // Respond to a PUT request to /api/cms
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Insert the danceEvent into the database
                $this->eventService->updateDanceEvent($data["eventId"], $data["name"], $data["date"], $data["price"], $data["quantity"], $data["location"], $data["artist"], $data["session"]);
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
                $this->eventService->deleteDanceEvent($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage();
            }


        }
    }
}
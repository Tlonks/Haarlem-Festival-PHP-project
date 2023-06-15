<?php
include_once __DIR__ . '/../../services/eventService.php';
include_once __DIR__ . '/apicontroller.php';

class historycmscontroller extends apicontroller
{
    private eventService $eventService;

    function __construct()
    {
        parent::__construct();
        $this->eventService = new eventService();
    }

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
                $event = new HistoryEvent();
                $event->name = ($data["name"]);
                $event->date = ($data["date"]);
                $event->price = ($data["price"]);
                $event->quantity = ($data["quantity"]);
                $event->location = ($data["location"]);
                $event->guide = ($data["guide"]);
                $event->language = ($data["language"]);
                $event->familyPrice = (60);

                // Insert the event into the database
                $this->eventService->addTypeOfEvent($event, 'history');
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header('Content-Type: application/json');
            $id = $_GET['eventId'];

            $result = $this->eventService->getHistoryEventById($id);

            echo json_encode($result);
        }

        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Create a new Event object using the data from the array
                $event = new HistoryEvent();
                $event->eventId = ($data["eventId"]);
                $event->name = ($data["name"]);
                $event->date = ($data["date"]);
                $event->price = ($data["price"]);
                $event->quantity = ($data["quantity"]);
                $event->location = ($data["location"]);
                $event->guide = ($data["guide"]);
                $event->language = ($data["language"]);
                $event->familyPrice = (60);

                // Insert the event into the database
                $this->eventService->updateHistoryEvent($event);

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
                $this->eventService->deleteHistoryEvent($id);
                return json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                return 'Caught exception: ' . $e->getMessage();
            }
        }
    }
}
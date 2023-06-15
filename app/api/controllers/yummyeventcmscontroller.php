<?php

include_once __DIR__ . '/../../services/eventService.php';
include_once __DIR__ . '/apicontroller.php';

class yummyeventcmscontroller extends apicontroller
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

        // Respond to a POST request to /api/yummyeventcms
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Create a new Event object using the data from the array
                include_once __DIR__ . '/../../models/YummyEvent.php';
                $event = new YummyEvent();
                $event->name = ($data["name"]);
                $event->date = ($data["date"]);
                $event->price = ($data["price"]);
                $event->quantity = ($data["quantity"]);
                $event->duration = ($data["duration"]);
                $event->restaurant = ($data["restaurant"]);
                $event->reservationPrice = ($data["rprice"]);

                // Insert the event into the database
                $this->eventService->addTypeOfEvent($event, 'yummy');
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        // Respond to a GET request to /api/yummyeventcms
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header('Content-Type: application/json');
            $id = $_GET['eventId'];

            $result = $this->eventService->getYummyEventById($id);

            echo json_encode($result);
        }

        // Respond to a PUT request to /api/yummyeventcms
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            try {
                // Get the raw JSON data from the request body
                $json = file_get_contents("php://input");

                // Convert the JSON data to an associative array
                $data = json_decode($json, true);

                // Insert the Event into the database
                $rprice = $data['rprice'];
                $this->eventService->updateYummyEvent($data, $rprice);
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);

        }

        // respond to a DELETE request to /api/yummyeventcms
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header('Content-Type: application/json');
            $id = $_GET['eventId'];
            // Delete the Event from the database
            try {
                $this->eventService->deleteYummyEvent($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage();
            }


        }
    }
}
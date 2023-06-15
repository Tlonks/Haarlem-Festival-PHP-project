<?php

include_once __DIR__ . '/../../services/ArtistService.php';
include_once __DIR__ . '/apicontroller.php';

class artistcmscontroller extends apicontroller
{
    private ArtistService $artistService;

    public function __construct()
    {
        parent::__construct();
        $this->artistService = new ArtistService();
    }

    public function index()
    {
        if ($this->checkKey()){
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                // Create a new artist object
                $artist = new artists();
                $artist->name = $_POST['name'];

                if (isset($_POST['id'])){
                    $artist->id = $_POST['id'];
                }

                //check if the picture field was sent in the request
                if (isset($_FILES['picture'])) {
                    // Read the file data
                    $picture = file_get_contents($_FILES['picture']['tmp_name']);
                    // Set the picture data
                    $artist->picture = $picture;
                }

                //checking whether it is an update or an insert
                if (isset($_POST['id'])){
                    $this->artistService->updateArtist($artist);
                }else{
                    $this->artistService->addArtist($artist);
                }
            } catch (Exception $e) {
                // Return an error message
                echo json_encode(["message" => $e->getMessage()]);
            }
            // Return a success message
            echo json_encode(["message" => "Success"]);
        }

        //Get request for one artist
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header('Content-Type: application/json');
            $id = $_GET['artistId'];

            $result = $this->artistService->getArtistById($id);

            echo json_encode($result);
        }

        //Delete request for one artist
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            header('Content-Type: application/json');
            $id = $_GET['artistId'];

            try {
                $this->artistService->deleteArtist($id);
                echo json_encode(["message" => "Success"]);
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage();
            }
        }
    }
}
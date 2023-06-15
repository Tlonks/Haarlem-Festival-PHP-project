<?php
include_once __DIR__ . "/../models/roleEnum.php";
include_once __DIR__ . "/../models/danceEvent.php";
include_once __DIR__ . '/../services/eventService.php';
include_once __DIR__ . '/../services/loginService.php';
include_once __DIR__ . '/../services/ArtistService.php';
include_once __DIR__ . '/../services/ProfileService.php';
include_once __DIR__ . '/../services/RegistrationService.php';
require_once __DIR__ . "/../services/MainTeylerPageService.php";
require_once __DIR__ . "/../models/MainTeylerContent.php";
require_once __DIR__ . "/../repositories/YummyRepository.php";
require_once __DIR__ . "/../services/apiKeyService.php";
require_once __DIR__ . "/../services/loginService.php";
require_once __DIR__ . "/../services/IntroInformationService.php";
require_once __DIR__ . "/../services/exportService.php";
require_once __DIR__ . "/../services/orderService.php";
require_once __DIR__ . "/../services/VenueService.php";

class cmscontroller
{
    public function __construct()
    {
        $this->CheckUserLogin();
    }

    public function index()
    {
        $eventService = new eventService();
        $model = $eventService->getAllEvents();


        require __DIR__ . '/../views/cms/index.php';
    }

    public function wysiwyg()
    {
        $pageService = new IntroInformationService();
        //checking if its post request and updating the page
        if ($_POST) {
            $id = $_POST['id'];
            $htmlData = $_POST['myTextarea'];
            $pageService->updatePage($id, $htmlData);
            header('Location: /cms/wysiwyg?id=' . $id);
        }

        //getting the correct page and displaying it
        $id = $_GET['id'];
        $page = $pageService->getPageById($id);
        require __DIR__ . '/../views/cms/wysiwyg.php';
    }

    public function dance()
    {

        $eventService = new eventService();

        $model = $eventService->getAllDanceEvents();

        require __DIR__ . '/../views/cms/dance.php';
    }

    public function wysiwygmanagement()
    {
        $pageService = new IntroInformationService();
        if (isset($_GET['deleteId'])) {
            $pageService->deletePage($_GET['deleteId']);
        }
        if ($_POST) {
            $pageService->addPage($_POST['title'], $_POST['category']);
        }

        $model = $pageService->getAllPages();
        require __DIR__ . '/../views/cms/wysiwygmanagement.php';
    }

    public function venue()
    {
        $service = new VenueService();
        $model = $service->getAllVenueEvents();

        require __DIR__ . '/../views/cms/venue.php';
    }

    public function history()
    {
        $eventService = new eventService();
        $model = $eventService->getAllHistoryEvents();

        require __DIR__ . '/../views/cms/history.php';
    }

    public function jazz()
    {

        $eventService = new eventService();
        $model = $eventService->getAllJazzEvents();
        $artistService = new ArtistService();
        $artists = $artistService->getAllArtists();

        require __DIR__ . '/../views/cms/jazz.php';
    }

    public function artist()
    {
        $artistService = new ArtistService();
        $model = $artistService->getAllArtists();

        require __DIR__ . '/../views/cms/artists.php';
    }

    public function apiManagement()
    {
        $loginService = new loginService();
        $model = $loginService->getAllUsers();

        require __DIR__ . '/../views/cms/apiManagement.php';
    }

    public function editKeys()
    {
        $keyService = new apiKeyService();
        $loginService = new loginService();
        if (isset($_POST['addButton'])) {

            $keyService->updateApiKey(htmlspecialchars($_POST['userId']));
            $loginService->refreshUser(htmlspecialchars($_SESSION['user']['email']));
            $this->apiManagement();
        }

        if (isset($_POST['deleteButton'])) {

            $keyService->deleteKey(htmlspecialchars($_POST['userId']));
            $loginService->refreshUser(htmlspecialchars($_SESSION['user']['email']));
            $this->apiManagement();
        }
    }

    public function scavengerHunt()
    {
        $service = new MainTeylerPageService();
        $content = $service->getAllContent();
        $picture = $service->getHeaderPicture();
        $count = 0;
        foreach ($content as $filledContent) {
            if ($filledContent->name == "Header") {
                $header = $filledContent->text;
                if ($picture[$count]->name == "Header") {
                    $headerPicture = "data:image/jpeg;base64," . base64_encode($picture[$count]->picture);
                }
            } elseif ($filledContent->name == "HeaderText") {
                $headerText = $filledContent->text;
            } elseif ($filledContent->name == "MainText") {
                $mainText = $filledContent->text;
            }
            $count++;
        }
        require __DIR__ . '/../views/cms/scavengerHunt.php';
    }
    //Tijmen oud niet meer in gebruik
    public function changeTeylerPage()
    {
        try {
            $service = new MainTeylerPageService();
            if (isset($_POST["editHeaderButton"])) {
                $header = htmlspecialchars($_POST["header"]);
                $service->editHeader($header);
            }

            if (isset($_POST["editSubButton"])) {
                $headerText = htmlspecialchars($_POST["headerText"]);
                $service->editHeaderText($headerText);
            }

            if (isset($_POST["editMainButton"])) {
                $mainText = htmlspecialchars($_POST["mainText"]);
                $service->editMainText($mainText);
            }

            if (isset($_POST["submit"])) {
                $fileName = basename($_FILES["image"]["name"]);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                if (!empty($_FILES["image"]["name"])) {
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'avif');
                    if (in_array($fileType, $allowTypes)) {

                        $image = $_FILES['image']['tmp_name'];
                        $img = file_get_contents($image);

                        $service->editHeaderPicture($img);
                    }
                }
            }

            $this->scavengerHunt();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function yummy()
    {
        $repository = new YummyRepository;
        $contentRestaurants = $repository->getAllContentOfRestaurants();
        require __DIR__ . '/../views/cms/yummy.php';
    }

    public function historySights()
    {
        require_once __DIR__ . "/../services/HistoryService.php";
        $service = new HistoryService();
        $model = $service->getAllSights();
        require __DIR__ . '/../views/cms/historySights.php';
    }

    public function users()
    {
        try {
            $service = new loginService();
            $users = $service->getAllUsers();
            require __DIR__ . '/../views/cms/users.php';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function export()
    {
        $error = "";
        $service = new orderService();
        $exportService = new exportService();
        $orders = $service->getAll();
        if (isset($_POST['export'])) {
            $filetype = htmlspecialchars($_POST['fileType']);
            $columnArray = array();
            array_push($columnArray, "order id");
            if (isset($_POST['total'])) {
                array_push($columnArray, $_POST['total']);
            }
            if (isset($_POST['VAT'])) {
                array_push($columnArray, $_POST['VAT']);
            }
            if (isset($_POST['isPaid'])) {
                array_push($columnArray, $_POST['isPaid']);
            }

            if (count($columnArray) == 1) {
                $error = "Please select atleast one column";
                require __DIR__ . '/../views/cms/export.php';
            } else {
                $exportService->export($orders, $filetype, $columnArray);

                require __DIR__ . '/../views/cms/export.php';
            }
        } else {
            require __DIR__ . '/../views/cms/export.php';
        }
    }

    private function checkUserLogin(): bool
    {
        if (isset($_SESSION['user']) && $_SESSION['Role'] == 3)
            return true;
        else {
            header('Location: /login');
            return false;
        }
    }

    public function orders()
    {
        require_once __DIR__ . '/../services/orderService.php';
        require_once __DIR__ . "/../services/CreatePdfService.php";
        $service = new orderService();
        $pdfservice = new CreatePdfService();
        $orders = $service->getAllOrders();

        if (isset($_POST['pdfDownload'])) {
            $orderItems = $service->getOrderItemInfo($orders[$_POST['pdfDownload']]['id']);
            $pdfInvoice = $pdfservice->createPDFInvoice('', $orders[$_POST['pdfDownload']], $orderItems, '', '', '', '', '', true);

            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="Invoice.pdf"');
            echo $pdfInvoice;
            exit;
        }

        require __DIR__ . '/../views/cms/orders.php';
    }

    public function order()
    {
        require_once __DIR__ . '/../services/orderService.php';
        $service = new orderService();
        $orderItems = $service->getOrderItems($_GET['id']);
        require __DIR__ . '/../views/cms/order.php';
    }

    public function yummyEvents()
    {
        require_once __DIR__ . '/../services/eventService.php';
        $eventService = new eventService();
        $model = $eventService->getAllYummyEvents();
        require __DIR__ . '/../views/cms/yummyEvents.php';
    }

    public function reservation()
    {
        require_once __DIR__ . '/../services/reservationService.php';
        $reservationService = new reservationService();
        $model = $reservationService->getAllReservations();
        require __DIR__ . '/../views/cms/reservation.php';
    }
}

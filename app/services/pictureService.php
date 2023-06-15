<?php
require_once __DIR__ . "/../repositories/PictureRepository.php";
class PictureService
{
    private $pictureRepository;

    function __construct()
    {
        $this->pictureRepository = new PictureRepository();
    }

    public function getPicture($id)
    {
        return $this->pictureRepository->getPicture($id);
    }
}

?>
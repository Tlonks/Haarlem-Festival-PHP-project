<?php
require_once __DIR__ . "/../repositories/ArtistRepository.php";

class ArtistService
{

    private $artistRepository;

    public function __construct()
    {
        $this->artistRepository = new ArtistRepository();
    }

    public function getAllArtists(){
        return $this->artistRepository->getAllArtists();
    }

    public function generateArtistHtml($name)
    {
        $artist = $this->artistRepository->getArtistByName($name);
        if (!$artist) {
            return '';
        }

        $encodedName = urlencode($artist->getName());
        $encodedName = str_replace('+', '', $encodedName);
        $html = '<a class="link_to_artist" href="mainJazz/detail' . $encodedName . '">';
        $html .= '<div class="bands_images" style="background-image: url(data:image/png;base64,' . $artist->getPicture() . ');">';
        $html .= '<div class="bands_description">' . $artist->getName() . '</div></div></a>';

        return $html;

    }

    public function generateDanceArtistHtml($name){
        $artist = $this->artistRepository->getArtistByName($name);
        if (!$artist) {
            return '';
        }

        $encodedName = urlencode($artist->getName());
        $encodedName = str_replace('+', '', $encodedName);
        $html = '<a class="link_to_artist" href="mainDance/detail' . $encodedName . '">';
        $html .= '<div class="bands_images" style="background-image: url(data:image/png;base64,' . $artist->getPicture() . ');">';
        $html .= '<div class="bands_description">' . $artist->getName() . '</div></div></a>';

        return $html;
    }

    public function addArtist(artists $artist)
    {
        $this->artistRepository->addArtist($artist);
    }

    public function getArtistById(mixed $id)
    {
        return $this->artistRepository->getArtistById($id);
    }

    public function updateArtist(artists $artist)
    {
        $this->artistRepository->updateArtist($artist);
    }

    public function deleteArtist(mixed $id)
    {
        $this->artistRepository->deleteArtist($id);
    }

    public function getAllAppearancesOfArtist($artist){
        return $this->artistRepository->getAllAppearancesOfArtist($artist);
    }
}


<?php
include_once __DIR__ . '/event.php';
class danceEvent extends event
{
    public string $location;
    public string $artist;
    public string $session;



    public int $infoId;
    public string $hall;
    public string $endTime;
    public int $artistId;

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getArtist(): string
    {
        return $this->artist;
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @param string $artist
     */
    public function setArtist(string $artist): void
    {
        $this->artist = $artist;
    }

    /**
     * @param string $session
     */
    public function setSession(string $session): void
    {
        $this->session = $session;
    }



}
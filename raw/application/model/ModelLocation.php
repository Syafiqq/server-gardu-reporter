<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:28 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
require_once APPPATH . '/model/util/CSerializable.php';

class ModelLocation implements CSerializable
{

    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;

    /**
     * Location constructor.
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude = null, float $longitude = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function cSerialize(): array
    {
        return ['latitude' => $this->getLatitude(), 'longitude' => $this->getLongitude()];
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }
}

?>

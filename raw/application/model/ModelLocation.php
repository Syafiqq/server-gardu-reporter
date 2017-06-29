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
     * @var float|null
     */
    private $latitude;
    /**
     * @var float|null
     */
    private $longitude;

    /**
     * ModelLocation constructor.
     * @param float|null $latitude
     * @param float|null $longitude
     */
    public function __construct(float $latitude = null, float $longitude = null)
    {
        if ($latitude !== null)
        {
            $this->latitude = $latitude;
        }
        if ($longitude !== null)
        {
            $this->longitude = $longitude;
        }
    }

    public function cSerialize(): array
    {
        return ['latitude' => $this->getLatitude(), 'longitude' => $this->getLongitude()];
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude = null)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude = null)
    {
        $this->longitude = $longitude;
    }
}

?>

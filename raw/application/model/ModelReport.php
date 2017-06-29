<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:32 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
require_once APPPATH . '/model/util/CSerializable.php';

class ModelReport implements CSerializable
{
    /**
     * @var string|null
     */
    private $substation;
    /**
     * @var float|null
     */
    private $voltage;
    /**
     * @var float|null
     */
    private $current;
    /**
     * @var ModelLocation|null
     */
    private $location;

    /**
     * ModelReport constructor.
     * @param string|null $substation
     * @param float|null $voltage
     * @param float|null $current
     * @param ModelLocation|null $location
     */
    public function __construct(string $substation = null, float $voltage = null, float $current = null, ModelLocation $location = null)
    {
        if ($substation !== null)
        {
            $this->substation = $substation;
        }
        if ($voltage !== null)
        {
            $this->voltage = $voltage;
        }
        if ($current !== null)
        {
            $this->current = $current;
        }
        if ($location !== null)
        {
            $this->location = $location;
        }
    }

    /**
     * @return array
     */
    public function cSerialize(): array
    {
        return [
            'substation' => $this->getSubstation(),
            'current' => $this->getCurrent(),
            'voltage' => $this->getVoltage(),
            'location' => $this->getLocation()->cSerialize(),
        ];
    }

    /**
     * @return null|string
     */
    public function getSubstation(): ?string
    {
        return $this->substation;
    }

    /**
     * @param null|string $substation
     */
    public function setSubstation(?string $substation = null)
    {
        $this->substation = $substation;
    }

    /**
     * @return float|null
     */
    public function getCurrent():?float
    {
        return $this->current;
    }

    /**
     * @param float|null $current
     */
    public function setCurrent(?float $current = null)
    {
        $this->current = $current;
    }

    /**
     * @return float|null
     */
    public function getVoltage():?float
    {
        return $this->voltage;
    }

    /**
     * @param float|null $voltage
     */
    public function setVoltage(?float $voltage = null)
    {
        $this->voltage = $voltage;
    }

    /**
     * @return ModelLocation|null
     */
    public function getLocation(): ?ModelLocation
    {
        return $this->location;
    }

    /**
     * @param ModelLocation|null $location
     */
    public function setLocation(?ModelLocation $location = null)
    {
        $this->location = $location;
    }


}

?>

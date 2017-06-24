<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:32 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
class ModelReport
{
    /**
     * @var string
     */
    private $substation;
    /**
     * @var float
     */
    private $voltage;
    /**
     * @var float
     */
    private $current;
    /**
     * @var ModelLocation
     */
    private $location;

    /**
     * Report constructor.
     * @param string $substation
     * @param float $voltage
     * @param float $current
     * @param ModelLocation $location
     */
    public function __construct(string $substation = null, float $voltage = null, float $current = null, ModelLocation $location = null)
    {
        $this->substation = $substation;
        $this->voltage = $voltage;
        $this->current = $current;
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getSubstation(): string
    {
        return $this->substation;
    }

    /**
     * @param string $substation
     */
    public function setSubstation(string $substation)
    {
        $this->substation = $substation;
    }

    /**
     * @return float
     */
    public function getVoltage(): float
    {
        return $this->voltage;
    }

    /**
     * @param float $voltage
     */
    public function setVoltage(float $voltage)
    {
        $this->voltage = $voltage;
    }

    /**
     * @return float
     */
    public function getCurrent(): float
    {
        return $this->current;
    }

    /**
     * @param float $current
     */
    public function setCurrent(float $current)
    {
        $this->current = $current;
    }

    /**
     * @return ModelLocation
     */
    public function getLocation(): ModelLocation
    {
        return $this->location;
    }

    /**
     * @param ModelLocation $location
     */
    public function setLocation(ModelLocation $location)
    {
        $this->location = $location;
    }


}

?>

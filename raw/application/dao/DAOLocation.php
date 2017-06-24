<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:37 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

require_once APPPATH . '/model/ModelLocation.php';

class DAOLocation
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var ModelLocation
     */
    private $location;

    /**
     * ORMLocation constructor.
     * @param int $id
     * @param ModelLocation $location
     */
    public function __construct(int $id = null, ModelLocation $location = null)
    {
        $this->id = $id;
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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

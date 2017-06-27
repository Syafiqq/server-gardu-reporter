<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:37 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

require_once APPPATH . '/model/ModelLocation.php';
require_once APPPATH . '/model/util/CSerializable.php';

/**
 * Class DAOLocation
 */
class DAOLocation implements CSerializable
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
     * @return array
     */
    public function cSerialize(): array
    {
        /** @var array $result */
        $result = ['id' => $this->getId()];
        $result = array_merge($result, $this->getLocation()->cSerialize());

        return $result;
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

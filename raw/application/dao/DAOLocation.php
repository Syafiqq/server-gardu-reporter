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
require_once APPPATH . '/model/util/CDBDataPopulator.php';

/**
 * Class DAOLocation
 */
class DAOLocation implements CSerializable, CDBDataPopulator
{
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var ModelLocation|null
     */
    private $location;

    /**
     * DAOLocation constructor.
     * @param int|null $id
     * @param ModelLocation|null $location
     */
    public function __construct(int $id = null, ModelLocation $location = null)
    {
        if ($id !== null)
        {
            $this->id = $id;
        }
        if ($location !== null)
        {
            $this->location = $location;
        }
    }

    function __get($name)
    {
        switch ($name)
        {
            case 'latitude' :
            {
                return $this->getLocation()->getLatitude();
            }
            break;
            case 'longitude' :
            {
                return $this->getLocation()->getLongitude();
            }
            break;
            default:
            {
                return $this->$name;
            }
        }
    }

    /**
     * @return null|ModelLocation
     */
    public function getLocation(): ?ModelLocation
    {
        return $this->location;
    }

    /**
     * @param ModelLocation $location
     */
    public function setLocation(?ModelLocation $location = null)
    {
        $this->location = $location;
    }

    /**
     * @return array
     */
    public function populate(): array
    {
        return $this->cSerialize();
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
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id = null)
    {
        $this->id = $id;
    }
}

?>

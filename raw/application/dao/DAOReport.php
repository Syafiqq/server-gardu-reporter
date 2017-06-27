<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:45 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

require_once APPPATH . '/model/ModelReport.php';
require_once APPPATH . '/model/ModelLocation.php';
require_once APPPATH . '/model/util/CSerializable.php';

/**
 * Class DAOReport
 */
class DAOReport implements CSerializable
{
    /**
     * @var int|null
     */
    private $idReport;
    /**
     * @var int|null
     */
    private $idLocation;
    /**
     * @var ModelReport|null
     */
    private $report;
    /**
     * @var string|null
     */
    private $createAt;
    /**
     * @var string|null
     */
    private $updateAt;

    /**
     * DAOReport constructor.
     * @param int|null $idReport
     * @param int|null $idLocation
     * @param ModelReport|null $report
     * @param string|null $createAt
     * @param string|null $updateAt
     */
    public function __construct($idReport = null, $idLocation = null, ModelReport $report = null, $createAt = null, $updateAt = null)
    {
        if ($idReport !== null)
        {
            $this->idReport = $idReport;
        }
        if ($idLocation !== null)
        {
            $this->idLocation = $idLocation;
        }
        if ($report !== null)
        {
            $this->report = $report;
        }
        if ($createAt !== null)
        {
            $this->createAt = $createAt;
        }
        if ($updateAt !== null)
        {
            $this->updateAt = $updateAt;
        }
    }

    function __set($name, $value)
    {
        switch ($name)
        {
            case 'report_id' :
            {
                $this->setIdReport($value);
            }
            break;
            case 'location_id' :
            {
                $this->setIdLocation($value);
            }
            break;
            case 'create_at' :
            {
                $this->setCreateAt($value);
            }
            break;
            case 'update_at' :
            {
                $this->setUpdateAt($value);
            }
            break;
            case 'location' :
            {
            }
            break;
            case 'substation' :
            {
                if (!isset($this->report))
                {
                    $this->report = new ModelReport();
                }
                $this->getReport()->setSubstation($value);
            }
            break;
            case 'voltage' :
            {
                if (!isset($this->report))
                {
                    $this->report = new ModelReport();
                }
                $this->getReport()->setVoltage($value);
            }
            break;
            case 'current' :
            {
                if (!isset($this->report))
                {
                    $this->report = new ModelReport();
                }
                $this->getReport()->setCurrent($value);
            }
            break;
            case 'latitude' :
            {
                if (!isset($this->report))
                {
                    $this->report = new ModelReport();
                }
                if ($this->report->getLocation() === null)
                {
                    $this->getReport()->setLocation(new ModelLocation());
                }
                $this->getReport()->getLocation()->setLatitude($value);
            }
            break;
            case 'longitude' :
            {
                if (!isset($this->report))
                {
                    $this->report = new ModelReport();
                }
                if ($this->report->getLocation() === null)
                {
                    $this->getReport()->setLocation(new ModelLocation());
                }
                $this->getReport()->getLocation()->setLongitude($value);
            }
            break;
            default :
            {
                $this->$name = $value;
            }
        }
    }

    /**
     * @return ModelReport|null
     */
    public function getReport(): ?ModelReport
    {
        return $this->report;
    }

    /**
     * @param ModelReport|null $report
     */
    public function setReport(?ModelReport $report)
    {
        $this->report = $report;
    }

    /**
     * @return array
     */
    public function cSerialize(): array
    {
        /** @var array $result */
        $result = [];
        $result['id_report'] = $this->getIdReport();
        $result['id_location'] = $this->getIdLocation();
        $result = array_merge($result, $this->getReport()->cSerialize());
        $result['create_at'] = $this->getCreateAt();
        $result['update_at'] = $this->getUpdateAt();

        return $result;
    }

    /**
     * @return int|null
     */
    public function getIdReport(): ?int
    {
        return $this->idReport;
    }

    /**
     * @param int|null $idReport
     */
    public function setIdReport(?int $idReport)
    {
        $this->idReport = $idReport;
    }

    /**
     * @return int|null
     */
    public function getIdLocation(): ?int
    {
        return $this->idLocation;
    }

    /**
     * @param int|null $idLocation
     */
    public function setIdLocation(?int $idLocation)
    {
        $this->idLocation = $idLocation;
    }

    /**
     * @return null|string
     */
    public function getCreateAt(): ?string
    {
        return $this->createAt;
    }

    /**
     * @param null|string $createAt
     */
    public function setCreateAt(?string $createAt)
    {
        $this->createAt = $createAt;
    }

    /**
     * @return null|string
     */
    public function getUpdateAt(): ?string
    {
        return $this->updateAt;
    }

    /**
     * @param null|string $updateAt
     */
    public function setUpdateAt(?string $updateAt)
    {
        $this->updateAt = $updateAt;
    }
}

?>

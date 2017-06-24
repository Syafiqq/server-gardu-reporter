<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:45 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

require_once APPPATH . '/model/ModelReport.php';

/**
 * Class DAOReport
 */
class DAOReport
{
    /**
     * @var int
     */
    private $idReport;
    /**
     * @var int
     */
    private $idLocation;
    /**
     * @var ModelReport
     */
    private $report;
    /**
     * @var string
     */
    private $createAt;
    /**
     * @var string
     */
    private $updateAt;

    /**
     * DAOReport constructor.
     * @param int $idReport
     * @param int $idLocation
     * @param ModelReport $report
     * @param string $createAt
     * @param string $updateAt
     */
    public function __construct($idReport = null, $idLocation = null, ModelReport $report = null, $createAt = null, $updateAt = null)
    {
        $this->idReport = $idReport;
        $this->idLocation = $idLocation;
        $this->report = $report;
        $this->createAt = $createAt;
        $this->updateAt = $updateAt;
    }

    /**
     * @return int
     */
    public function getIdReport(): int
    {
        return $this->idReport;
    }

    /**
     * @param int $idReport
     */
    public function setIdReport(int $idReport)
    {
        $this->idReport = $idReport;
    }

    /**
     * @return int
     */
    public function getIdLocation(): int
    {
        return $this->idLocation;
    }

    /**
     * @param int $idLocation
     */
    public function setIdLocation(int $idLocation)
    {
        $this->idLocation = $idLocation;
    }

    /**
     * @return ModelReport
     */
    public function getReport(): ModelReport
    {
        return $this->report;
    }

    /**
     * @param ModelReport $report
     */
    public function setReport(ModelReport $report)
    {
        $this->report = $report;
    }

    /**
     * @return string
     */
    public function getCreateAt(): string
    {
        return $this->createAt;
    }

    /**
     * @param string $createAt
     */
    public function setCreateAt(string $createAt)
    {
        $this->createAt = $createAt;
    }

    /**
     * @return string
     */
    public function getUpdateAt(): string
    {
        return $this->updateAt;
    }

    /**
     * @param string $updateAt
     */
    public function setUpdateAt(string $updateAt)
    {
        $this->updateAt = $updateAt;
    }


}

?>

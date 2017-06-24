<?php

/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 21 June 2017, 6:45 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

require_once APPPATH . '/model/ModelReport.php';

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
     * ORMReport constructor.
     * @param int $idReport
     * @param int $idLocation
     * @param ModelReport $report
     */
    public function __construct(int $idReport = null, int $idLocation = null, ModelReport $report = null)
    {
        $this->idReport = $idReport;
        $this->idLocation = $idLocation;
        $this->report = $report;
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


}

?>

<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 24 June 2017, 12:06 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/dao/DAOReport.php';
require_once APPPATH . '/dao/DAOLocation.php';

/**
 * Class MReport
 */
class MReport extends CI_Model
{
    /**
     * MReport constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    /**
     * @param DAOReport $report
     * @param MLocation $mLocation
     * @return int
     */
    public function insert(DAOReport &$report, MLocation &$mLocation)
    {
        $location = new DAOLocation(null, $report->getReport()->getLocation());

        /** @var int $locationID */
        $locationID = $mLocation->insert($location);
        $report->setIdLocation($locationID);

        /** @var ModelReport $reportModel */
        $reportModel = $report->getReport();
        $query = 'INSERT INTO `report`(`id`, `substation`, `current`, `voltage`, `location`, `create_at`, `update_at`) VALUES (NULL, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);';
        $this->db->query($query, [$reportModel->getSubstation(), $reportModel->getCurrent(), $reportModel->getVoltage(), $report->getIdLocation()]);

        /** @var int $reportID */
        $reportID = $this->db->insert_id();
        $report->setIdReport($reportID);

        return $reportID;
    }
}

?>

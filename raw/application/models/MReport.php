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
require_once APPPATH . '/model/ModelReport.php';
require_once APPPATH . '/model/ModelLocation.php';

/**
 * Class MReport
 * @property  CI_DB_mysqli_driver db
 * @property  MLocation mLocation
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
     * @return int|null
     */
    public function insert(DAOReport &$report): ?int
    {
        $CI =& get_instance();
        $CI->load->model('mLocation');

        /** @var int|null $reportID */
        $reportID = null;

        $location = new DAOLocation(null, $report->getReport()->getLocation());
        /** @var int|null $locationID */
        $locationID = $CI->mLocation->insert($location);
        if (!empty($locationID))
        {
            $report->setIdLocation($locationID);
            if ($this->db->insert('`report`', $report->populate()))
            {
                $reportID = $this->db->insert_id();
                $report->setIdReport($reportID);
            }
        }

        return $reportID;
    }

    /**
     * @param int|null $id
     * @return array
     */
    public function find(?int $id = null): array
    {
        $this->db->select('`report`.`id` AS \'report_id\', `report`.`substation`, `report`.`current`, `report`.`voltage`, `location`.`id` AS \'location_id\', `location`.`latitude`, `location`.`longitude`');
        $this->db->from('`report`');
        $this->db->join('`location`', '`report`.`location` = `location`.`id`', 'LEFT OUTER');
        if (!empty($id))
        {
            $this->db->where('`report`.`id`', $id);
        }
        $this->db->order_by('`report`.`id`', 'ASC');

        return $this->db->get()->result('DAOReport');
    }
}

?>

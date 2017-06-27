<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 24 June 2017, 11:52 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/dao/DAOLocation.php';

/**
 * Class MLocation
 * @property CI_DB_mysqli_driver db
 */
class MLocation extends CI_Model
{
    /**
     * MLocation constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    /**
     * @param DAOLocation $location
     * @return int|null
     */
    public function insert(DAOLocation &$location): ?int
    {
        /** @var int|null $locationID */
        $locationID = null;

        if ($this->db->insert('`location`', $location->populate()))
        {
            $locationID = $this->db->insert_id();
            $location->setId($locationID);
        }

        return $locationID;
    }
}

?>

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
     * @return int
     */
    public function insert(DAOLocation $location)
    {
        /** @var ModelLocation $locationModel */
        $locationModel = $location->getLocation();

        $query = 'INSERT INTO `location`(`id`, `latitude`, `longitude`) VALUES (NULL, ?, ?);';
        $this->db->query($query, [$locationModel->getLatitude(), $locationModel->getLongitude()]);

        /** @var int $locationID */
        $locationID = $this->db->insert_id();
        $location->setId($locationID);

        return $locationID;
    }
}

?>

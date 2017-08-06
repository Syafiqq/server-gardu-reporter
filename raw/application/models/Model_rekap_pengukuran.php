<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 05 August 2017, 6:24 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder db
 */
class Model_rekap_pengukuran extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    /**
     * @param string $select
     * @param null|string $from
     * @param null|string $to
     * @return CI_DB_result array
     * @internal param array|null|string $id
     */
    public function find_gardu($select, $from = null, $to = null)
    {
        $this->db->select($select);
        $this->db->from('`v_rekap_ukurgardufix`');
        if (!is_null($from))
        {
            $this->db->where('`tgl_pengukuran` >=', $from);
        }
        if (!is_null($to))
        {
            $this->db->where('`tgl_pengukuran` <=', $to);
        }
        $this->db->order_by('`v_rekap_ukurgardufix`.`id_ukur_gardu`', 'ASC');
        $response = $this->db->get();

        return $response;
    }

    /**
     * @param string $select
     * @param null|string $from
     * @param null|string $to
     * @return CI_DB_result array
     * @internal param array|null|string $id
     */
    public function find_tegangan_ujung($select, $from = null, $to = null)
    {
        $this->db->select($select);
        $this->db->from('`v_rekap_tegujungfix`');
        if (!is_null($from))
        {
            $this->db->where('`tgl_pengukuran` >=', $from);
        }
        if (!is_null($to))
        {
            $this->db->where('`tgl_pengukuran` <=', $to);
        }
        $this->db->order_by('`v_rekap_tegujungfix`.`id_ukur_gardu`', 'ASC');
        $response = $this->db->get();

        return $response;
    }

    /**
     * @param string $select
     * @param null|string $from
     * @param null|string $to
     * @return CI_DB_result array
     * @internal param array|null|string $id
     */
    public function find_gardu_trafo($select, $from = null, $to = null)
    {
        $this->db->select($select);
        $this->db->from('`v_rekap_tegujungfix`');
        if (!is_null($from))
        {
            $this->db->where('`tgl_pengukuran` >=', $from);
        }
        if (!is_null($to))
        {
            $this->db->where('`tgl_pengukuran` <=', $to);
        }
        $this->db->order_by('`v_rekap_tegujungfix`.`id_ukur_gardu`', 'ASC');
        $response = $this->db->get();

        return $response;
    }

}

?>

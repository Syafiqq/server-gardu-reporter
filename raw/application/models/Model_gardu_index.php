<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 23 July 2017, 12:04 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder db
 */
class Model_gardu_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    /**
     * @param string $select
     * @param null|string|array $id
     * @return CI_DB_result array
     */
    public function find($select, $id = null)
    {
        $this->db->select($select);
        $this->db->from('`datagardu_tb`');
        if (!is_null($id))
        {
            $ids = [];
            if (!is_array($id))
            {
                $ids = [$id];
            }
            else
            {
                $ids = array_merge($ids, $id);
            }

            foreach ($ids as $_id)
            {
                if (is_numeric($_id))
                {
                    $this->db->or_where('`datagardu_tb`.`no_gardu`', $_id);
                }
            }
        }
        $this->db->order_by('`datagardu_tb`.`no_gardu`', 'ASC');
        $response = $this->db->get();

        return $response;
    }

    public function id_check($id = 0)
    {
        $this->db->select('`datagardu_tb`.`no_gardu`');
        $this->db->from('`datagardu_tb`');
        $this->db->where('`datagardu_tb`.`no_gardu`', $id);
        $response = $this->db->get();

        return $response->num_rows() > 0;
    }

    public function insert($data)
    {
        return $this->db->insert('`datagardu_tb`', $data);
    }

    public function delete($id)
    {
        $this->db->where('`no_gardu`', $id);
        $result = $this->db->delete('`datagardu_tb`');

        return is_bool($result) ? $result : true;
    }

    public function update($id, $data)
    {
        $this->db->where('`no_gardu`', $id);

        return $this->db->update('`datagardu_tb`', $data);
    }
}

?>

<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 18 July 2017, 9:36 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder db
 */
class Model_gardu_induk extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    /**
     * @param string $select
     * @param null|int|array $id
     * @return CI_DB_result array
     */
    public function find($select, $id = null)
    {
        $this->db->select($select);
        $this->db->from('`datagarduinduk_tb`');
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
                    $this->db->or_where('`datagarduinduk_tb`.`id_tb_gardu_induk`', $_id);
                }
            }
        }
        $this->db->order_by('`datagarduinduk_tb`.`id_tb_gardu_induk`', 'ASC');
        $response = $this->db->get();

        return $response;
    }

    public function id_check($id = 0)
    {
        $this->db->select('`datagarduinduk_tb`.`id_tb_gardu_induk`');
        $this->db->from('`datagarduinduk_tb`');
        $this->db->where('`datagarduinduk_tb`.`id_tb_gardu_induk`', $id);
        $response = $this->db->get();

        return $response->num_rows() > 0;
    }

    public function insert($data)
    {
        return $this->db->insert('`datagarduinduk_tb`', $data);
    }

    public function delete($id)
    {
        $this->db->where('`id_tb_gardu_induk`', $id);
        $result = $this->db->delete('`datagarduinduk_tb`');

        return is_bool($result) ? $result : true;
    }
}

?>

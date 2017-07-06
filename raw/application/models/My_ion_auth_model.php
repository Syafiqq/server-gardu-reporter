<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 06 July 2017, 6:06 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/models/Ion_auth_model.php';

/**
 * Class My_ion_auth_model
 * @property CI_DB_query_builder db
 */
class My_ion_auth_model extends Ion_auth_model
{
    /**
     * My_ion_auth_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('ion_auth_extend');
    }

    /**
     * @param $identity
     * @param $password
     * @param mixed $group
     * @param bool $remember
     * @return bool
     */
    public function login_and_check($identity, $password, $group, $remember = false): bool
    {
        $this->trigger_events('pre_login');

        if (empty($identity) || empty($password))
        {
            $this->set_error('login_unsuccessful');

            return false;
        }

        $this->trigger_events('extra_where');

        $query = $this->db->select($this->identity_column . ', email, id, password, active, last_login')
            ->where($this->identity_column, $identity)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        if ($this->is_max_login_attempts_exceeded($identity))
        {
            // Hash something anyway, just to take up time
            $this->hash_password($password);

            $this->trigger_events('post_login_unsuccessful');
            $this->set_error('login_timeout');

            return false;
        }

        if ($query->num_rows() === 1)
        {

            $user = $query->row();

            $password = $this->hash_password_db($user->id, $password);

            if (($password === true) && ($this->in_group($group, $user->id)))
            {
                if ($user->active == 0)
                {
                    $this->trigger_events('post_login_unsuccessful');
                    $this->set_error('login_unsuccessful_not_active');

                    return false;
                }

                $this->set_session($user);

                $this->update_last_login($user->id);

                $this->clear_login_attempts($identity);

                if ($remember && $this->config->item('remember_users', 'ion_auth'))
                {
                    $this->remember_user($user->id);
                }

                $this->trigger_events(array('post_login', 'post_login_successful'));
                $this->set_message('login_successful');

                return true;
            }
        }

        // Hash something anyway, just to take up time
        $this->hash_password($password);

        $this->increase_login_attempts($identity);

        $this->trigger_events('post_login_unsuccessful');
        $this->set_error('login_unsuccessful');

        return false;
    }


    /**
     * in_group
     *
     * @param mixed $check_group group(s) to check
     * @param int $id user id
     * @param bool $check_all check if all groups is present, or any of the groups
     *
     * @return bool
     * @author Phil Sturgeon
     **/
    public function in_group($check_group, $id = 0, $check_all = false)
    {
        if (!is_array($check_group))
        {
            $check_group = array($check_group);
        }

        if (isset($this->_cache_user_in_group[$id]))
        {
            $groups_array = $this->_cache_user_in_group[$id];
        }
        else
        {
            $users_groups = $this->get_users_groups($id)->result();
            $groups_array = array();
            foreach ($users_groups as $group)
            {
                $groups_array[$group->id] = $group->name;
            }
            $this->_cache_user_in_group[$id] = $groups_array;
        }
        foreach ($check_group as $key => $value)
        {
            $groups = (is_string($value)) ? $groups_array : array_keys($groups_array);

            /**
             * if !all (default), in_array
             * if all, !in_array
             */
            if (in_array($value, $groups) xor $check_all)
            {
                /**
                 * if !all (default), true
                 * if all, false
                 */
                return !$check_all;
            }
        }

        /**
         * if !all (default), false
         * if all, true
         */
        return $check_all;
    }
}

?>

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
     * @var array $api_token ;
     * @var int $token_id ;
     */
    private $api_token;
    private $token_id;

    /**
     * My_ion_auth_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('ion_auth_extended');
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

                $user->group = $group;

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

    /**
     * @param $identity
     * @param $password
     * @param mixed $group
     * @param bool $remember
     * @return bool
     */
    public function login_for_api($identity, $password, $group, $remember = false): bool
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

                $this->deactivate_previous_token($user->id);

                $this->setApiToken($this->refreshToken());

                $this->register_new_token($user->id, $this->getApiToken(), $this->config->item('csrf_expire'));

                $this->update_last_login($user->id);

                $this->clear_login_attempts($identity);

                if ($remember && $this->config->item('remember_users', 'ion_auth'))
                {
                    $this->remember_user($user->id);
                }

                $this->trigger_events(array('post_login', 'post_login_successful'));
                $this->messages = [];
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
     * @param int $id
     */
    private function deactivate_previous_token(int $id): void
    {
        $this->trigger_events('pre_deactivate_previous_token');

        $data = ['active' => 0];
        $this->db->where('user', $id);
        $this->db->update('token', $data);

        $this->trigger_events(['post_deactivate_previous_token', 'post_deactivate_previous_token_successful']);
        $this->set_message('deactivate_previous_token_successful');
    }

    /**
     * @param array $session_token
     */
    private function setApiToken(array $session_token): void
    {
        $this->api_token = $session_token;
    }

    /**
     * @return array
     */
    private function refreshToken(): array
    {
        return [
            'token' => bin2hex(random_bytes(32)),
            'refresh' => bin2hex(random_bytes(32)),
        ];
    }

    /**
     * @param int $id
     * @param array $getApiToken
     * @param int $expiration
     */
    private function register_new_token(int $id, array $getApiToken, int $expiration): void
    {
        $this->trigger_events('pre_register_new_token');

        $data = [
            'id' => null,
            'user' => $id,
            'token' => $getApiToken['token'],
            'refresh' => $getApiToken['refresh'],
            'active' => 1
        ];
        $this->db->set('create_at', 'NOW()', false);
        $this->db->set('expiration', "DATE_ADD(NOW(), INTERVAL {$expiration} DAY)", false);

        while (!$this->db->insert('token', $data))
        {
            $this->setApiToken($getApiToken = $this->refreshToken());
            $data['token'] = $getApiToken['token'];
            $data['refresh'] = $getApiToken['refresh'];
        }

        $this->trigger_events(['post_register_new_token', 'post_register_new_token_successful']);
        $this->set_message('register_new_token_successful');
    }

    /**
     * @return array|null
     */
    public function getApiToken(): ?array
    {
        return $this->api_token;
    }

    /**
     * @param string $token
     * @return bool
     */
    public function check_token($token): bool
    {
        $this->trigger_events('pre_check_token');

        if (empty($token))
        {
            $this->set_error('check_token_unsuccessful');

            return false;
        }

        $query = $this->db->select('*')
            ->where('token', $token)
            ->where('`expiration` > NOW()', null, false)
            ->where('active', 1)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get('token');

        if ($query->num_rows() === 1)
        {
            $user = $query->row();
            $this->setTokenId($user->user);

            $this->trigger_events(array('post_check_token', 'post_check_token_successful'));
            $this->messages = [];
            $this->set_message('check_token_successful');

            return true;
        }
        $this->trigger_events('post_check_token_unsuccessful');
        $this->set_error('check_token_unsuccessful');

        return false;
    }

    /**
     * @return int
     */
    public function getTokenId(): int
    {
        return $this->token_id;
    }

    /**
     * @param int $token_id
     */
    public function setTokenId(int $token_id)
    {
        $this->token_id = $token_id;
    }

    public function users_and_its_group($select)
    {
        $this->trigger_events('users_and_its_group');

        $this->db->select($select);
        $this->db->from('`users`');
        $this->db->join('`users_groups`', '`users`.`id` = `users_groups`.`user_id`', 'LEFT OUTER');
        $this->db->join('`groups`', '`users_groups`.`group_id` = `groups`.`id`', 'LEFT OUTER');
        $this->db->order_by('`users`.`id`', 'ASC');
        $this->db->order_by('`groups`.`id`', 'ASC');
        $response = $this->db->get();

        return $response;
    }

    public function remove_from_group($group_ids = false, $user_id = false)
    {
        $result = parent::remove_from_group($group_ids, $user_id);
        if ($result)
        {
            $this->set_message('success_remove_from_group');
        }
        else
        {
            $this->set_message('failed_remove_from_group');
        }

        return $result;
    }
}

?>

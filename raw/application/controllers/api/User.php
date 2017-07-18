<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 17 July 2017, 3:05 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/MY_REST_Controller.php';

/**
 * Class Profile
 * @property CI_Form_validation form_validation
 * @property CI_Lang lang
 * @property CI_Loader load
 * @property CI_Config config
 * @property CI_Security security
 * @property Ion_auth ion_auth
 * @property array data
 * @property CI_Input input
 * @property CI_Session session
 * @property MReport mReport
 */
class User extends \Restserver\Libraries\MY_REST_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    /**
     * @var mixed|null|string $language
     */
    private $language;

    /**
     * @var array $callback_request
     */
    private $callback_request;

    /**
     * @var array $callback_request
     */

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->callback_request = [];

        $this->load->database();
        /** @noinspection PhpParamsInspection */
        $this->load->library(['session', 'ion_auth']);
        $this->load->helper(['url']);
    }

    /**
     *
     */
    public function find_get()
    {
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in())
        {
            $code = $this->getOrDefault('code', '');
            switch ($code)
            {
                case 'B24AC' :
                {
                    $response = array_merge($response, $this->get_all_user_and_its_group());
                    $response['data']['status'] = 1;
                }
                break;
                default:
                {
                    $response['data']['status'] = 0;
                    $response['data']['message']['message']['validation']['info'] = $this->validation_errors();
                }
            }
        }
        else
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message']['notify']['find']['info'] = [$this->lang->line('user_get_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     * @return array
     */
    private function get_all_user_and_its_group(): array
    {
        /** @var array $response */
        $response = [];

        $users = $this->ion_auth->users_and_its_group("`users`.`id` AS 'user_id', `groups`.`id` AS 'group_id', `users`.`username` AS 'user_username', `users`.`email` AS 'user_email', `groups`.`description` AS 'group_description'")->result_array();
        if (empty($users))
        {
            $response['data']['user'] = [];
        }
        else
        {
            $response['data']['user'] = $users;
        }

        return $response;
    }

    /**
     *
     */
    public function delete_delete()
    {
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $data['user_id'] = $this->deleteOrDefault('user_id', null);
            $data['group_id'] = $this->deleteOrDefault('group_id', null);

            $isValid = !empty($data['user_id']);
            if ($isValid)
            {
                if ($this->ion_auth->remove_from_group($data['group_id'], $data['user_id']))
                {
                    $response['data']['status'] = 1;
                    if (($data['user_id'] == $this->session->userdata('user_id')) && ($data['group_id'] == 1))
                    {
                        $response['data']['redirect'] = $this->deleteOrDefault('redirector', site_url('/auth/logout'));
                    }
                    $flashdata = array_merge([], explode(PHP_EOL, trim($this->ion_auth->messages())));
                    $this->session->set_flashdata(['flashdata' => ['message' => $flashdata]]);
                    $response['data']['message']['notify']['delete']['success'] = $flashdata;
                }
                else
                {
                    $response['data']['status'] = 0;
                    $response['data']['message']['notify']['delete']['danger'] = array_merge([], explode(PHP_EOL, trim($this->ion_auth->errors())));
                }
            }
            else
            {
                $this->lang->load('ion_auth_extended', $this->language);

                $response['data']['message']['notify']['validation']['info'] = [$this->lang->line('insufficient_data')];
            }
        }
        else
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message']['notify']['validation']['info'] = [$this->lang->line('user_delete_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function register_post()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['username'] = $this->postOrDefault('username', null);
            $data['email'] = $this->postOrDefault('email', null);
            $data['password'] = $this->postOrDefault('password', null);
            $data['password_conf'] = $this->postOrDefault('password_conf', null);
            $data['role'] = $this->postOrDefault('role', null);

            $this->lang->load(['common/auth/common_auth_register_form', 'auth'], $this->language);

            $this->callback_request['_email_existence_check'] = true;
            $this->callback_request['_role_existence_check'] = true;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('username', $this->lang->line('common_auth_register_form_username_label'), 'required');
            $this->form_validation->set_rules('email', $this->lang->line('common_auth_register_form_email_label'), 'required|valid_email|callback__email_existence_check');
            $this->form_validation->set_rules('role', $this->lang->line('common_auth_register_form_role_label'), 'required|callback__role_existence_check');
            $this->form_validation->set_rules('password', $this->lang->line('common_auth_register_form_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_conf]');
            $this->form_validation->set_rules('password_conf', $this->lang->line('common_auth_register_form_password_confirmation_label'), 'required');

            $isValid = $this->form_validation->run();
            if ($isValid)
            {
                $data['email'] = strtolower($data['email']);
                if ($this->ion_auth->register($data['username'], $data['password'], $data['email'], [], [$data['role']]))
                {
                    $response['data']['status'] = 1;
                    $response['data']['message']['message']['register']['success'] = array_merge([], explode(PHP_EOL, trim($this->ion_auth->messages())));
                }
                else
                {
                    $response['data']['status'] = 0;
                    $response['data']['message']['message']['register']['danger'] = array_merge([], explode(PHP_EOL, trim($this->ion_auth->errors())));
                }
            }
            else
            {
                $response['data']['status'] = 0;
                $response['data']['message']['message']['validation']['info'] = $this->validation_errors();
            }
            $response['data']['csrf']['name'] = $this->security->get_csrf_token_name();
            $response['data']['csrf']['hash'] = $this->security->get_csrf_hash();
        }
        else
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message']['message']['register']['info'] = [$this->lang->line('client_account_creation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     * @param $email
     * @return bool|mixed
     */
    public function _email_existence_check($email)
    {
        if (empty($this->callback_request['_email_existence_check']))
        {
            show_404();
        }
        else
        {
            if ($this->ion_auth->email_check($email))
            {
                $this->form_validation->set_message('_email_existence_check', $this->lang->line('form_validation_is_unique'));

                return false;
            }
            else
            {
                return true;
            }
        }
    }

    /**
     * @param $role
     * @return bool|mixed
     */
    public function _role_existence_check($role)
    {
        if (empty($this->callback_request['_role_existence_check']))
        {
            show_404();
        }
        else
        {
            if (is_null($this->ion_auth->group($role)->result_array()))
            {
                $this->lang->load('ion_auth_extended', $this->language);

                $this->form_validation->set_message('_role_existence_check', $this->lang->line('check_role_undefined'));

                return false;
            }
            else
            {
                return true;
            }
        }
    }
}

?>

<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 05 July 2017, 6:11 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/MY_REST_Controller.php';


/**
 * Class Auth
 * @property CI_Form_validation form_validation
 * @property CI_Lang lang
 * @property CI_Loader load
 * @property CI_Config config
 * @property CI_Security security
 * @property Ion_auth ion_auth
 * @property array data
 * @property CI_Input input
 * @property CI_Session session
 */
class Auth extends \Restserver\Libraries\MY_REST_Controller
{
    /**
     * @var int
     */
    private $clientGroup;
    /**
     * @var mixed|null|string
     */
    private $language;

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
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->database();
        /** @noinspection PhpParamsInspection */
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);

        $this->clientGroup = 2;

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->language = empty($this->language = get_cookie('common_language')) ? $this->config->item('language') : $this->language;
    }

    /**
     *
     */
    public function login_post($group = 'admin')
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in())
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message']['login']['info'] = $this->lang->line('login_already_active');
        }
        else
        {
            /** @var array $data */
            $data = [];

            $data['identity'] = $this->postOrDefault('identity', null);
            $data['password'] = $this->postOrDefault('password', null);

            $this->lang->load(['common/auth/common_auth_login_form', 'auth'], $this->language);
            $this->form_validation->set_data($data);

            $this->form_validation->set_rules('identity', $this->lang->line('common_auth_login_form_email_label'), 'required|valid_email');
            $this->form_validation->set_rules('password', $this->lang->line('common_auth_login_form_password_label'), 'required');

            if ($this->form_validation->run() == true)
            {
                $remember = boolval(($this->postOrDefault('remember_me', false)));

                if ($this->ion_auth->login_and_check($data['identity'], $data['password'], $group, $remember))
                {
                    $response['data']['redirect'] = $this->postOrDefault('redirector', site_url('/dashboard'));
                    $response['data']['status']   = 1;
                    $flashdata                    = array_merge([], explode(PHP_EOL, trim($this->ion_auth->messages())));
                    $this->session->set_flashdata(['flashdata' => ['message' => $flashdata]]);
                }
                else
                {
                    $response['data']['status']                     = 0;
                    $response['data']['message']['login']['danger'] = [];
                    $response['data']['message']['login']['danger'] = array_merge($response['data']['message']['login']['danger'], explode(PHP_EOL, trim($this->ion_auth->errors())));
                    $response['data']['csrf']['name']               = $this->security->get_csrf_token_name();
                    $response['data']['csrf']['hash']               = $this->security->get_csrf_hash();
                }
            }
            else
            {
                $response['data']['status']                        = 0;
                $response['data']['message']['validation']['info'] = $this->validation_errors();
                $response['data']['csrf']['name']                  = $this->security->get_csrf_token_name();
                $response['data']['csrf']['hash']                  = $this->security->get_csrf_hash();
            }
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function register_client_post()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];

        log_message('ERROR', var_export($this->post(), true));

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data   = [];
            $tables = $this->config->item('tables', 'ion_auth');

            $data['username']      = $this->postOrDefault('username', null);
            $data['identity']      = $this->postOrDefault('identity', null);
            $data['password']      = $this->postOrDefault('password', null);
            $data['password_conf'] = $this->postOrDefault('password_conf', null);

            $this->lang->load(['common/auth/common_auth_register_form', 'auth'], $this->language);

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('username', $this->lang->line('common_auth_register_form_username_label'), 'required');
            $this->form_validation->set_rules('identity', $this->lang->line('common_auth_register_form_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
            $this->form_validation->set_rules('password', $this->lang->line('common_auth_register_form_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_conf]');
            $this->form_validation->set_rules('password_conf', $this->lang->line('common_auth_register_form_password_confirmation_label'), 'required');

            $isValid = $this->form_validation->run();
            if ($isValid)
            {
                $data['identity'] = strtolower($data['identity']);
                if ($this->ion_auth->register($data['username'], $data['password'], $data['identity'], [], [$this->clientGroup]))
                {
                    $response['data']['status']                       = 1;
                    $response['data']['message']['notify']['success'] = array_merge([], explode(PHP_EOL, trim($this->ion_auth->messages())));
                }
                else
                {
                    $response['data']['status']                        = 0;
                    $response['data']['message']['register']['danger'] = array_merge([], explode(PHP_EOL, trim($this->ion_auth->errors())));
                }
            }
            else
            {
                $response['data']['status']                        = 0;
                $response['data']['message']['validation']['info'] = $this->validation_errors();
            }
            $response['data']['csrf']['name'] = $this->security->get_csrf_token_name();
            $response['data']['csrf']['hash'] = $this->security->get_csrf_hash();
        }
        else
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message']['register']['info'] = [$this->lang->line('client_account_creation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }
}

?>

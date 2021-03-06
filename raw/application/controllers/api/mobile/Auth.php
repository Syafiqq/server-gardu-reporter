<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 29 July 2017, 6:35 AM.
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
        $this->language = $this->getOrDefault('lang', $this->config->item('language'));

        /** @var array $response */
        $response                   = [];
        $response['data']['status'] = 0;

        if (!empty($_SERVER['HTTP_X_ACCESS_PERMISSION']) && !empty($_SERVER['HTTP_X_ACCESS_GUARD']))
        {
            if (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_PERMISSION']), $this->config->item('non_csrf_permission')) === 0)
            {
                if (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_GUARD']), $this->config->item('non_csrf_guard')) === 0)
                {
                    $this->lang->load(['common/auth/common_auth_login_form', 'auth'], $this->language);

                    /** @var array $data */
                    $data = [];

                    $data['identity'] = $this->postOrDefault('identity', null);
                    $data['password'] = $this->postOrDefault('password', null);

                    $this->form_validation->set_data($data);

                    $this->form_validation->set_rules('identity', $this->lang->line('common_auth_login_form_email_label'), 'required|valid_email');
                    $this->form_validation->set_rules('password', $this->lang->line('common_auth_login_form_password_label'), 'required');

                    if ($this->form_validation->run() == true)
                    {
                        $remember = false;

                        if ($this->ion_auth->login_for_api($data['identity'], $data['password'], $group, $remember))
                        {
                            $response['data']['token']   = $this->ion_auth->getApiToken();
                            $response['data']['status']  = 1;
                            $response['data']['message'] = array_merge([], is_array($this->ion_auth->messages()) ? $this->ion_auth->messages() : explode(PHP_EOL, trim($this->ion_auth->messages())));
                        }
                        else
                        {
                            $response['data']['message'] = array_merge([], is_array($this->ion_auth->errors()) ? $this->ion_auth->errors() : explode(PHP_EOL, trim($this->ion_auth->errors())));
                        }
                    }
                    else
                    {
                        $response['data']['message'] = $this->validation_errors();
                    }
                }
            }
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    public function check_post()
    {
        $this->language = $this->getOrDefault('lang', $this->config->item('language'));

        /** @var array $response */
        $response                   = [];
        $response['data']['status'] = 0;

        if (!empty($_SERVER['HTTP_X_ACCESS_PERMISSION']) && !empty($_SERVER['HTTP_X_ACCESS_GUARD']))
        {
            if (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_PERMISSION']), $this->config->item('non_csrf_permission')) === 0)
            {
                if (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_GUARD']), $this->config->item('non_csrf_guard')) === 0)
                {
                    $this->lang->load(['common/auth/common_auth_token_form', 'auth'], $this->language);

                    /** @var array $data */
                    $data = [];

                    $data['token'] = $this->postOrDefault('token', null);
                    $this->form_validation->set_data($data);

                    $this->form_validation->set_rules('token', $this->lang->line('common_auth_token_form_token_label'), 'required');

                    if ($this->form_validation->run() == true)
                    {
                        if ($this->ion_auth->check_token($data['token']))
                        {
                            $response['data']['status']  = 1;
                            $response['data']['message'] = array_merge([], is_array($this->ion_auth->messages()) ? $this->ion_auth->messages() : explode(PHP_EOL, trim($this->ion_auth->messages())));
                        }
                        else
                        {
                            $response['data']['message'] = array_merge([], is_array($this->ion_auth->errors()) ? $this->ion_auth->errors() : explode(PHP_EOL, trim($this->ion_auth->errors())));
                        }
                    }
                    else
                    {
                        $response['data']['message'] = $this->validation_errors();
                    }
                }
            }
        }
        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

}

?>

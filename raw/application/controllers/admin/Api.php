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
 * Class Api
 * @property CI_Form_validation form_validation
 * @property CI_Lang lang
 * @property CI_Loader load
 * @property CI_Config config
 * @property Ion_auth ion_auth
 * @property array data
 * @property CI_Input input
 * @property CI_Session session
 */
class Api extends \Restserver\Libraries\MY_REST_Controller
{
    private $authGroup;
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

        $this->authGroup = 'admin';

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }

    /**
     *
     */
    public function login_post()
    {
        $this->load->library('session');

        /** @var array $data
         * @var array $response
         */
        $data = [];
        $response = [];

        $data['identity'] = $this->postOrDefault('identity', null);
        $data['password'] = $this->postOrDefault('password', null);

        $this->lang->load(['common/auth/common_auth_login_form', 'auth']);

        $this->form_validation->set_rules('identity', $this->lang->line('common_auth_login_form_email_label'), 'required|valid_email');
        $this->form_validation->set_rules('password', $this->lang->line('common_auth_login_form_password_label'), 'required');

        $this->form_validation->set_data($data);
        if ($this->form_validation->run() == true)
        {
            $remember = boolval(($this->postOrDefault('remember_me', false)));

            if ($this->ion_auth->login_and_check($data['identity'], $data['password'], $this->authGroup, $remember))
            {
                $response['data']['redirect'] = site_url('/');
                $flashdata = array_merge([], explode(PHP_EOL, trim($this->ion_auth->messages())));
                $this->session->set_flashdata(['flashdata' => $flashdata]);
            }
            else
            {
                $response['data']['message']['login']['danger'] = [];
                $response['data']['message']['login']['danger'] = array_merge($response['data']['message']['login']['danger'], explode(PHP_EOL, trim($this->ion_auth->errors())));
            }
        }
        else
        {
            $response['data']['message']['validation']['info'] = $this->validation_errors();
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }
}

?>

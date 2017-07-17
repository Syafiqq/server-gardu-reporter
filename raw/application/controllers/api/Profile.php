<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 16 July 2017, 8:04 PM.
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
class Profile extends \Restserver\Libraries\MY_REST_Controller
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

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->callback_request = [];

        $this->load->database();
        /** @noinspection PhpParamsInspection */
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url']);
    }

    /**
     *
     */
    public function update_patch()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $data['username'] = $this->patchOrDefault('username', null);
            $data['email'] = $this->patchOrDefault('email', null);

            $this->lang->load(['common/auth/common_auth_register_form', 'auth'], $this->language);
            $this->form_validation->set_data($data);

            $this->callback_request['_email_update_check'] = true;

            // validate form input
            $this->form_validation->set_rules('username', $this->lang->line('common_auth_register_form_username_label'), 'required');
            $this->form_validation->set_rules('email', $this->lang->line('common_auth_register_form_email_label'), 'required|valid_email|callback__email_update_check');

            $isValid = $this->form_validation->run();
            if ($isValid)
            {
                $data['email'] = strtolower($data['email']);
                if ($this->ion_auth->update($this->session->userdata('user_id'), $data))
                {
                    $response['data']['status'] = 1;
                    $response['data']['redirect'] = $this->patchOrDefault('redirector', site_url('/dashboard'));
                    $flashdata = array_merge([], explode(PHP_EOL, trim($this->ion_auth->messages())));
                    $this->session->set_flashdata(['flashdata' => ['message' => $flashdata]]);
                    $response['data']['message']['message']['update']['success'] = $flashdata;
                }
                else
                {
                    $response['data']['status'] = 0;
                    $response['data']['message']['message']['update']['danger'] = array_merge([], explode(PHP_EOL, trim($this->ion_auth->errors())));
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

            $response['data']['message']['message']['update']['info'] = [$this->lang->line('profile_update_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     * @param $email
     * @return bool|mixed
     */
    public function _email_update_check($email)
    {
        if (empty($this->callback_request['_email_update_check']))
        {
            show_404();
        }
        else
        {
            if ($this->ion_auth->email_check($email) && (strcmp($this->session->userdata('email'), $email) != 0))
            {
                $this->form_validation->set_message('_email_update_check', $this->lang->line('form_validation_is_unique'));

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

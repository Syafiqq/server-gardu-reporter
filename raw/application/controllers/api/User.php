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
}

?>

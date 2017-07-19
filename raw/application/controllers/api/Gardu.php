<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 18 July 2017, 9:32 PM.
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
 * @property Model_gardu_induk mgi
 * @property MReport mReport
 */
class Gardu extends \Restserver\Libraries\MY_REST_Controller
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
    public function induk_find_get()
    {
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in())
        {
            $code = $this->getOrDefault('code', '');
            switch ($code)
            {
                case 'C41AF' :
                {
                    $response = array_merge($response, $this->get_all_gardu_induk());
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
    private function get_all_gardu_induk(): array
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_gardu_induk', 'mgi');

        $users = $this->mgi->find("`datagarduinduk_tb`.`id_tb_gardu_induk` AS 'id', `datagarduinduk_tb`.`nama_gardu_induk` AS 'name'")->result_array();
        if (empty($users))
        {
            $response['data']['gardu_induk'] = [];
        }
        else
        {
            $response['data']['gardu_induk'] = $users;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    /**
     *
     */
    public function induk_delete_delete()
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

            $data['id_tb_gardu_induk'] = $this->deleteOrDefault('user_id', null);
            $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);

            $isValid = !empty($data['id_tb_gardu_induk']);
            if ($isValid)
            {
                $this->load->model('model_gardu_induk', 'mgi');
                if ($this->mgi->delete($data['id_tb_gardu_induk']))
                {
                    $response['data']['status'] = 1;
                    $response['data']['message']['notify']['delete']['success'] = [$this->lang->line('gardu_induk_common_delete_success')];

                }
                else
                {
                    $response['data']['status'] = 0;
                    $response['data']['message']['notify']['delete']['danger'] = [$this->lang->line('gardu_induk_common_delete_failed')];
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
            $response['data']['message']['message']['register']['info'] = [$this->lang->line('gardu_induk_common_deletion_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function induk_register_post()
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

            $data['id_tb_gardu_induk'] = $this->postOrDefault('id', null);
            $data['nama_gardu_induk'] = $this->postOrDefault('name', null);

            $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);

            $this->callback_request['_id_existence_check'] = true;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('id_tb_gardu_induk', $this->lang->line('gardu_induk_common_form_id_label'), 'required|callback__id_existence_check');
            $this->form_validation->set_rules('nama_gardu_induk', $this->lang->line('gardu_induk_common_form_name_label'), 'required');

            $isValid = $this->form_validation->run();
            $isValid &= (($data['id_tb_gardu_induk'] = intval($data['id_tb_gardu_induk'])) != 0);
            if ($isValid)
            {
                $this->load->model('model_gardu_induk', 'mgi');
                if ($this->mgi->insert($data))
                {
                    $response['data']['status'] = 1;
                    $response['data']['message']['message']['register']['success'] = [$this->lang->line('gardu_induk_common_insert_success')];
                }
                else
                {
                    $response['data']['status'] = 0;
                    $response['data']['message']['message']['register']['danger'] = [$this->lang->line('gardu_induk_common_insert_failed')];
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
            $response['data']['message']['message']['register']['info'] = [$this->lang->line('gardu_induk_common_creation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     * @param int $id
     * @return bool|mixed
     */
    public function _id_existence_check($id)
    {
        if (empty($this->callback_request['_id_existence_check']))
        {
            show_404();

            return false;
        }
        else
        {
            unset($this->callback_request['_id_existence_check']);
            $id = intval($id);

            $this->load->model('model_gardu_induk', 'mgi');
            if ($this->mgi->id_check($id))
            {
                $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);
                $this->form_validation->set_message('_id_existence_check', $this->lang->line('gardu_induk_common_form_id_exists_error'));

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
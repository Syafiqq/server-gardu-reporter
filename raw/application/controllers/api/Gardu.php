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
 * @property Ion_auth|My_ion_auth_model ion_auth
 * @property array data
 * @property CI_Input input
 * @property CI_Session session
 * @property Model_gardu_induk mgi
 * @property Model_gardu_penyulang mgp
 * @property Model_gardu_index mgidx
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

    private $group;

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

        $this->group = $this->session->userdata('group');
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
                    $response['data']['status']                                   = 0;
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
        $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_induk'] = $this->deleteOrDefault('user_id', null);

            $isValid = !empty($data['id_tb_gardu_induk']);
            if ($isValid)
            {
                $this->load->model('model_gardu_induk', 'mgi');
                if ($this->mgi->delete($data['id_tb_gardu_induk']))
                {
                    $response['data']['status']                                 = 1;
                    $response['data']['message']['notify']['delete']['success'] = [$this->lang->line('gardu_induk_common_delete_success')];

                }
                else
                {
                    $response['data']['status']                                = 0;
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
        $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);

        if ($this->ion_auth->logged_in() && (($this->group === 'admin') ^ ($this->group === 'members')))
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_induk'] = $this->postOrDefault('id', null);
            $data['nama_gardu_induk']  = $this->postOrDefault('name', null);

            $this->callback_request['_id_gardu_induk_existence_check']             = true;
            $this->callback_request['_id_gardu_induk_existence_check_need_exists'] = false;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('id_tb_gardu_induk', $this->lang->line('gardu_induk_common_form_id_label'), 'required|callback__id_gardu_induk_existence_check');
            $this->form_validation->set_rules('nama_gardu_induk', $this->lang->line('gardu_induk_common_form_name_label'), 'required');

            $isValid = $this->form_validation->run();
            $isValid &= (($data['id_tb_gardu_induk'] = intval($data['id_tb_gardu_induk'])) != 0);
            if ($isValid)
            {
                $this->load->model('model_gardu_induk', 'mgi');
                if ($this->mgi->insert($data))
                {
                    $response['data']['status']                                    = 1;
                    $response['data']['message']['message']['register']['success'] = [$this->lang->line('gardu_induk_common_insert_success')];
                }
                else
                {
                    $response['data']['status']                                   = 0;
                    $response['data']['message']['message']['register']['danger'] = [$this->lang->line('gardu_induk_common_insert_failed')];
                }
            }
            else
            {
                $response['data']['status']                                   = 0;
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
     *
     */
    public function induk_update_patch()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];
        $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);

        if ($this->ion_auth->logged_in() && (($this->group === 'admin') ^ ($this->group === 'members')))
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_induk'] = $this->patchOrDefault('id', null);
            $data['nama_gardu_induk']  = $this->patchOrDefault('name', null);

            $this->callback_request['_id_gardu_induk_existence_check']             = true;
            $this->callback_request['_id_gardu_induk_existence_check_need_exists'] = true;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('id_tb_gardu_induk', $this->lang->line('gardu_induk_common_form_id_label'), 'required|callback__id_gardu_induk_existence_check');
            $this->form_validation->set_rules('nama_gardu_induk', $this->lang->line('gardu_induk_common_form_name_label'), 'required');

            $isValid = $this->form_validation->run();
            $isValid &= (($data['id_tb_gardu_induk'] = intval($data['id_tb_gardu_induk'])) != 0);
            if ($isValid)
            {
                $this->load->model('model_gardu_induk', 'mgi');
                $id = $data['id_tb_gardu_induk'];
                unset($data['id_tb_gardu_induk']);
                if ($this->mgi->update($id, $data))
                {
                    $response['data']['status']                                  = 1;
                    $response['data']['message']['message']['update']['success'] = [$this->lang->line('gardu_induk_common_update_success')];
                    $response['data']['message']['notify']['update']['success']  = $response['data']['message']['message']['update']['success'];
                }
                else
                {
                    $response['data']['status']                                 = 0;
                    $response['data']['message']['message']['update']['danger'] = [$this->lang->line('gardu_induk_common_update_failed')];
                }
            }
            else
            {
                $response['data']['status']                                   = 0;
                $response['data']['message']['message']['validation']['info'] = $this->validation_errors();
            }
        }
        else
        {
            $response['data']['message']['message']['update']['info'] = [$this->lang->line('gardu_induk_common_manipulation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     * @param int $id
     * @return bool|mixed
     */
    public function _id_gardu_induk_existence_check($id)
    {
        $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);
        if (empty($this->callback_request['_id_gardu_induk_existence_check']))
        {
            show_404();

            return false;
        }
        else
        {
            unset($this->callback_request['_id_gardu_induk_existence_check']);
            $need_exist = isset($this->callback_request['_id_gardu_induk_existence_check_need_exists']) ? $this->callback_request['_id_gardu_induk_existence_check_need_exists'] : false;
            $id         = intval($id);

            $this->load->model('model_gardu_induk', 'mgi');
            if ($this->mgi->id_check($id))
            {
                if ($need_exist)
                {
                    return true;
                }
                else
                {
                    $this->form_validation->set_message('_id_gardu_induk_existence_check', $this->lang->line('gardu_induk_common_form_id_exists_error'));

                    return false;
                }
            }
            else
            {
                if ($need_exist)
                {
                    $this->form_validation->set_message('_id_gardu_induk_existence_check', $this->lang->line('gardu_induk_common_form_id_not_exists_error'));

                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }

    //=================================================================================================================

    /**
     *
     */
    public function penyulang_find_get()
    {
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in())
        {
            $code = $this->getOrDefault('code', '');
            switch ($code)
            {
                case 'B28FE' :
                {
                    $response = array_merge($response, $this->get_all_gardu_penyulang());
                }
                break;
                default:
                {
                    $response['data']['status']                                   = 0;
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
    private function get_all_gardu_penyulang(): array
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_gardu_penyulang', 'mgp');

        $users = $this->mgp->find("`datagardupenyulang_tb`.`id_tb_gardu_penyulang` AS 'id', `datagardupenyulang_tb`.`nama_penyulang` AS 'name'")->result_array();
        if (empty($users))
        {
            $response['data']['gardu_penyulang'] = [];
        }
        else
        {
            $response['data']['gardu_penyulang'] = $users;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    /**
     *
     */
    public function penyulang_delete_delete()
    {
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_penyulang'] = $this->deleteOrDefault('user_id', null);
            $this->lang->load('layout/gardu/penyulang/gardu_penyulang_common', $this->language);

            $isValid = !empty($data['id_tb_gardu_penyulang']);
            if ($isValid)
            {
                $this->load->model('model_gardu_penyulang', 'mgp');
                if ($this->mgp->delete($data['id_tb_gardu_penyulang']))
                {
                    $response['data']['status']                                 = 1;
                    $response['data']['message']['notify']['delete']['success'] = [$this->lang->line('gardu_penyulang_common_delete_success')];

                }
                else
                {
                    $response['data']['status']                                = 0;
                    $response['data']['message']['notify']['delete']['danger'] = [$this->lang->line('gardu_penyulang_common_delete_failed')];
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
            $response['data']['message']['message']['register']['info'] = [$this->lang->line('gardu_penyulang_common_deletion_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function penyulang_register_post()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_penyulang'] = $this->postOrDefault('id', null);
            $data['nama_penyulang']        = $this->postOrDefault('name', null);

            $this->lang->load('layout/gardu/penyulang/gardu_penyulang_common', $this->language);

            $this->callback_request['_id_gardu_penyulang_existence_check']             = true;
            $this->callback_request['_id_gardu_penyulang_existence_check_need_exists'] = false;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('id_tb_gardu_penyulang', $this->lang->line('gardu_penyulang_common_form_id_label'), 'required|callback__id_gardu_penyulang_existence_check');
            $this->form_validation->set_rules('nama_penyulang', $this->lang->line('gardu_penyulang_common_form_name_label'), 'required');

            $isValid = $this->form_validation->run();
            $isValid &= (($data['id_tb_gardu_penyulang'] = intval($data['id_tb_gardu_penyulang'])) != 0);
            if ($isValid)
            {
                $this->load->model('model_gardu_penyulang', 'mgp');
                if ($this->mgp->insert($data))
                {
                    $response['data']['status']                                    = 1;
                    $response['data']['message']['message']['register']['success'] = [$this->lang->line('gardu_penyulang_common_insert_success')];
                }
                else
                {
                    $response['data']['status']                                   = 0;
                    $response['data']['message']['message']['register']['danger'] = [$this->lang->line('gardu_penyulang_common_insert_failed')];
                }
            }
            else
            {
                $response['data']['status']                                   = 0;
                $response['data']['message']['message']['validation']['info'] = $this->validation_errors();
            }
            $response['data']['csrf']['name'] = $this->security->get_csrf_token_name();
            $response['data']['csrf']['hash'] = $this->security->get_csrf_hash();
        }
        else
        {
            $response['data']['message']['message']['register']['info'] = [$this->lang->line('gardu_penyulang_common_creation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function penyulang_update_patch()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_penyulang'] = $this->patchOrDefault('id', null);
            $data['nama_penyulang']        = $this->patchOrDefault('name', null);

            $this->lang->load('layout/gardu/penyulang/gardu_penyulang_common', $this->language);

            $this->callback_request['_id_gardu_penyulang_existence_check']             = true;
            $this->callback_request['_id_gardu_penyulang_existence_check_need_exists'] = true;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('id_tb_gardu_penyulang', $this->lang->line('gardu_penyulang_common_form_id_label'), 'required|callback__id_gardu_penyulang_existence_check');
            $this->form_validation->set_rules('nama_penyulang', $this->lang->line('gardu_penyulang_common_form_name_label'), 'required');

            $isValid = $this->form_validation->run();
            $isValid &= (($data['id_tb_gardu_penyulang'] = intval($data['id_tb_gardu_penyulang'])) != 0);
            if ($isValid)
            {
                $this->load->model('model_gardu_penyulang', 'mgp');
                $id = $data['id_tb_gardu_penyulang'];
                unset($data['id_tb_gardu_penyulang']);
                if ($this->mgp->update($id, $data))
                {
                    $response['data']['status']                                  = 1;
                    $response['data']['message']['message']['update']['success'] = [$this->lang->line('gardu_penyulang_common_update_success')];
                    $response['data']['message']['notify']['update']['success']  = $response['data']['message']['message']['update']['success'];
                }
                else
                {
                    $response['data']['status']                                 = 0;
                    $response['data']['message']['message']['update']['danger'] = [$this->lang->line('gardu_penyulang_common_update_failed')];
                }
            }
            else
            {
                $response['data']['status']                                   = 0;
                $response['data']['message']['message']['validation']['info'] = $this->validation_errors();
            }
        }
        else
        {
            $response['data']['message']['message']['update']['info'] = [$this->lang->line('gardu_penyulang_common_manipulation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     * @param int $id
     * @return bool|mixed
     */
    public function _id_gardu_penyulang_existence_check($id)
    {
        if (empty($this->callback_request['_id_gardu_penyulang_existence_check']))
        {
            show_404();

            return false;
        }
        else
        {
            unset($this->callback_request['_id_gardu_penyulang_existence_check']);
            $need_exist = isset($this->callback_request['_id_gardu_penyulang_existence_check_need_exists']) ? $this->callback_request['_id_gardu_penyulang_existence_check_need_exists'] : false;
            $id         = intval($id);

            $this->load->model('model_gardu_penyulang', 'mgp');
            if ($this->mgp->id_check($id))
            {
                if ($need_exist)
                {
                    return true;
                }
                else
                {
                    $this->lang->load('layout/gardu/penyulang/gardu_penyulang_common', $this->language);
                    $this->form_validation->set_message('_id_gardu_penyulang_existence_check', $this->lang->line('gardu_penyulang_common_form_id_exists_error'));

                    return false;
                }
            }
            else
            {
                if ($need_exist)
                {
                    $this->lang->load('layout/gardu/penyulang/gardu_penyulang_common', $this->language);
                    $this->form_validation->set_message('_id_gardu_penyulang_existence_check', $this->lang->line('gardu_penyulang_common_form_id_not_exists_error'));

                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }

    //=================================================================================================================

    /**
     *
     */
    public function index_find_get()
    {
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in())
        {
            $code = $this->getOrDefault('code', '');
            switch ($code)
            {
                case 'FE37A' :
                {
                    $response = array_merge($response, $this->get_all_gardu_index());
                }
                break;
                case 'B231A' :
                {
                    $response = array_merge($response, $this->get_all_gardu_index_id());
                }
                break;
                default:
                {
                    $response['data']['status']                                   = 0;
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
    private function get_all_gardu_index(): array
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_gardu_index', 'mgidx');

        $users = $this->mgidx->find("
        `datagardu_tb`.`id_tb_gardu_induk` AS 'induk_id', 
        `datagardu_tb`.`id_tb_gardu_penyulang` AS 'penyulang_id', 
        `datagardu_tb`.`jns_gardu` AS 'jenis', 
        `datagardu_tb`.`no_gardu` AS 'no', 
        `datagardu_tb`.`lokasi` AS 'lokasi', 
        `datagardu_tb`.`merk_trafo` AS 'merk', 
        `datagardu_tb`.`no_seri_trafo` AS 'serial', 
        `datagardu_tb`.`daya_trafo` AS 'daya', 
        `datagardu_tb`.`fasa` AS 'fasa', 
        `datagardu_tb`.`tap` AS 'tap', 
        `datagardu_tb`.`jml_jurusan` AS 'jurusan', 
        `datagardu_tb`.`latitude` AS 'lat', 
        `datagardu_tb`.`longitude` AS 'long'"
        )->result_array();
        if (empty($users))
        {
            $response['data']['gardu_index'] = [];
        }
        else
        {
            $response['data']['gardu_index'] = $users;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    /**
     * @return array
     */
    private function get_all_gardu_index_id(): array
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_gardu_index', 'mgidx');

        $users = $this->mgidx->find("
        `datagardu_tb`.`id_tb_gardu_induk` AS 'induk_id', 
        `datagardu_tb`.`id_tb_gardu_penyulang` AS 'penyulang_id', 
        `datagardu_tb`.`jns_gardu` AS 'jenis', 
        `datagardu_tb`.`no_gardu` AS 'no', 
        `datagardu_tb`.`lokasi` AS 'lokasi'"
        )->result_array();
        if (empty($users))
        {
            $response['data']['gardu_index'] = [];
        }
        else
        {
            $response['data']['gardu_index'] = $users;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    /**
     * @return array
     */
    public function index_detail_get()
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_gardu_index', 'mgidx');
        $id = $this->getOrDefault('gardu', null);

        $users = $this->mgidx->find("
        `datagardu_tb`.`id_tb_gardu_induk` AS 'induk_id', 
        `datagardu_tb`.`id_tb_gardu_penyulang` AS 'penyulang_id', 
        `datagardu_tb`.`jns_gardu` AS 'jenis', 
        `datagardu_tb`.`no_gardu` AS 'no', 
        `datagardu_tb`.`lokasi` AS 'lokasi', 
        `datagardu_tb`.`merk_trafo` AS 'merk', 
        `datagardu_tb`.`no_seri_trafo` AS 'serial', 
        `datagardu_tb`.`daya_trafo` AS 'daya', 
        `datagardu_tb`.`fasa` AS 'fasa', 
        `datagardu_tb`.`tap` AS 'tap', 
        `datagardu_tb`.`jml_jurusan` AS 'jurusan', 
        `datagardu_tb`.`latitude` AS 'lat', 
        `datagardu_tb`.`longitude` AS 'long'"
            , $id)->result_array();
        if (empty($users))
        {
            $response['data']['gardu_index_detail'] = [];
        }
        else
        {
            $response['data']['gardu_index_detail'] = $users;
        }
        $response['data']['status'] = 1;

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function index_delete_delete()
    {
        /** @var array $response */
        $response = [];
        $this->lang->load('layout/gardu/index/gardu_index_common', $this->language);

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_index'] = $this->deleteOrDefault('user_id', null);

            $isValid = !empty($data['id_tb_gardu_index']);
            if ($isValid)
            {
                $this->load->model('model_gardu_index', 'mgidx');
                if ($this->mgidx->delete($data['id_tb_gardu_index']))
                {
                    $response['data']['status']                                 = 1;
                    $response['data']['message']['notify']['delete']['success'] = [$this->lang->line('gardu_index_common_delete_success')];

                }
                else
                {
                    $response['data']['status']                                = 0;
                    $response['data']['message']['notify']['delete']['danger'] = [$this->lang->line('gardu_index_common_delete_failed')];
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
            $response['data']['message']['message']['register']['info'] = [$this->lang->line('gardu_index_common_deletion_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function index_register_post()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];
        $this->lang->load('layout/gardu/index/gardu_index_common', $this->language);

        if ($this->ion_auth->logged_in() && (($this->group === 'admin') ^ ($this->group === 'members')))
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_induk']     = $this->postOrDefault('induk_id', null);
            $data['id_tb_gardu_penyulang'] = $this->postOrDefault('penyulang_id', null);
            $data['jns_gardu']             = $this->postOrDefault('jenis', null);
            $data['no_gardu']              = $this->postOrDefault('no', null);
            $data['lokasi']                = $this->postOrDefault('lokasi', null);
            $data['merk_trafo']            = $this->postOrDefault('merk', null);
            $data['no_seri_trafo']         = $this->postOrDefault('serial', null);
            $data['daya_trafo']            = $this->postOrDefault('daya', null);
            $data['fasa']                  = $this->postOrDefault('fasa', null);
            $data['tap']                   = $this->postOrDefault('tap', null);
            $data['jml_jurusan']           = $this->postOrDefault('jurusan', null);
            $data['latitude']              = $this->postOrDefault('lat', null);
            $data['longitude']             = $this->postOrDefault('long', null);

            $this->callback_request['_id_gardu_index_existence_check']                 = true;
            $this->callback_request['_id_gardu_induk_existence_check']                 = true;
            $this->callback_request['_id_gardu_penyulang_existence_check']             = true;
            $this->callback_request['_id_gardu_index_existence_check_need_exists']     = false;
            $this->callback_request['_id_gardu_induk_existence_check_need_exists']     = true;
            $this->callback_request['_id_gardu_penyulang_existence_check_need_exists'] = true;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('id_tb_gardu_induk', $this->lang->line('gardu_index_common_form_induk_id_label'), 'required|integer|callback__id_gardu_induk_existence_check');
            $this->form_validation->set_rules('id_tb_gardu_penyulang', $this->lang->line('gardu_index_common_form_penyulang_id_label'), 'required|integer|callback__id_gardu_penyulang_existence_check');
            $this->form_validation->set_rules('jns_gardu', $this->lang->line('gardu_index_common_form_jenis_label'), 'required|in_list[Portal,Cantol]');
            $this->form_validation->set_rules('no_gardu', $this->lang->line('gardu_index_common_form_no_label'), 'required|callback__id_gardu_index_existence_check');
            $this->form_validation->set_rules('lokasi', $this->lang->line('gardu_index_common_form_lokasi_label'), 'required');
            $this->form_validation->set_rules('merk_trafo', $this->lang->line('gardu_index_common_form_merk_label'), 'required');
            $this->form_validation->set_rules('no_seri_trafo', $this->lang->line('gardu_index_common_form_serial_label'), 'required');
            $this->form_validation->set_rules('daya_trafo', $this->lang->line('gardu_index_common_form_daya_label'), 'required|integer');
            $this->form_validation->set_rules('fasa', $this->lang->line('gardu_index_common_form_fasa_label'), 'required');
            $this->form_validation->set_rules('tap', $this->lang->line('gardu_index_common_form_tap_label'), 'required|integer');
            $this->form_validation->set_rules('jml_jurusan', $this->lang->line('gardu_index_common_form_jurusan_label'), 'required|integer');
            $this->form_validation->set_rules('latitude', $this->lang->line('gardu_index_common_form_lat_label'), 'required');
            $this->form_validation->set_rules('longitude', $this->lang->line('gardu_index_common_form_long_label'), 'required');

            $isValid = $this->form_validation->run();
            if ($isValid)
            {
                $this->load->model('model_gardu_index', 'mgidx');
                if ($this->mgidx->insert($data))
                {
                    $response['data']['status']                                    = 1;
                    $response['data']['message']['message']['register']['success'] = [$this->lang->line('gardu_index_common_insert_success')];
                }
                else
                {
                    $response['data']['status']                                   = 0;
                    $response['data']['message']['message']['register']['danger'] = [$this->lang->line('gardu_index_common_insert_failed')];
                }
            }
            else
            {
                $response['data']['status']                                   = 0;
                $response['data']['message']['message']['validation']['info'] = $this->validation_errors();
            }
            $response['data']['csrf']['name'] = $this->security->get_csrf_token_name();
            $response['data']['csrf']['hash'] = $this->security->get_csrf_hash();
        }
        else
        {
            $response['data']['message']['message']['register']['info'] = [$this->lang->line('gardu_index_common_creation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function index_update_patch()
    {
        $this->load->library('session');
        /** @var array $response */
        $response = [];
        $this->lang->load('layout/gardu/index/gardu_index_common', $this->language);


        if ($this->ion_auth->logged_in() && (($this->group === 'admin') ^ ($this->group === 'members')))
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['jns_gardu']     = $this->patchOrDefault('jenis', null);
            $data['no_gardu']      = $this->patchOrDefault('no', null);
            $data['lokasi']        = $this->patchOrDefault('lokasi', null);
            $data['merk_trafo']    = $this->patchOrDefault('merk', null);
            $data['no_seri_trafo'] = $this->patchOrDefault('serial', null);
            $data['fasa']          = $this->patchOrDefault('fasa', null);
            $data['tap']           = $this->patchOrDefault('tap', null);
            $data['jml_jurusan']   = $this->patchOrDefault('jurusan', null);
            $data['latitude']      = $this->patchOrDefault('lat', null);
            $data['longitude']     = $this->patchOrDefault('long', null);

            $this->callback_request['_id_gardu_index_existence_check']             = true;
            $this->callback_request['_id_gardu_index_existence_check_need_exists'] = true;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('jns_gardu', $this->lang->line('gardu_index_common_form_jenis_label'), 'required|in_list[Portal,Cantol]');
            $this->form_validation->set_rules('no_gardu', $this->lang->line('gardu_index_common_form_no_label'), 'required|callback__id_gardu_index_existence_check');
            $this->form_validation->set_rules('lokasi', $this->lang->line('gardu_index_common_form_lokasi_label'), 'required');
            $this->form_validation->set_rules('merk_trafo', $this->lang->line('gardu_index_common_form_merk_label'), 'required');
            $this->form_validation->set_rules('no_seri_trafo', $this->lang->line('gardu_index_common_form_serial_label'), 'required');
            $this->form_validation->set_rules('fasa', $this->lang->line('gardu_index_common_form_fasa_label'), 'required');
            $this->form_validation->set_rules('tap', $this->lang->line('gardu_index_common_form_tap_label'), 'required|integer');
            $this->form_validation->set_rules('jml_jurusan', $this->lang->line('gardu_index_common_form_jurusan_label'), 'required|integer');
            $this->form_validation->set_rules('latitude', $this->lang->line('gardu_index_common_form_lat_label'), 'required');
            $this->form_validation->set_rules('longitude', $this->lang->line('gardu_index_common_form_long_label'), 'required');

            $isValid = $this->form_validation->run();
            if ($isValid)
            {
                $this->load->model('model_gardu_index', 'mgidx');
                $id = $data['no_gardu'];
                unset($data['no_gardu']);
                if ($this->mgidx->update($id, $data))
                {
                    $response['data']['status']                                  = 1;
                    $response['data']['message']['message']['update']['success'] = [$this->lang->line('gardu_index_common_update_success')];
                    $response['data']['message']['notify']['update']['success']  = $response['data']['message']['message']['update']['success'];
                }
                else
                {
                    $response['data']['status']                                 = 0;
                    $response['data']['message']['message']['update']['danger'] = [$this->lang->line('gardu_index_common_update_failed')];
                }
            }
            else
            {
                $response['data']['status']                                   = 0;
                $response['data']['message']['message']['validation']['info'] = $this->validation_errors();
            }
        }
        else
        {
            $response['data']['message']['message']['update']['info'] = [$this->lang->line('gardu_index_common_manipulation_forbidden')];
        }

        log_message('ERROR', var_export($response, true));

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     * @param string $id
     * @return bool|mixed
     */
    public function _id_gardu_index_existence_check($id)
    {
        $this->lang->load('layout/gardu/index/gardu_index_common', $this->language);

        if (empty($this->callback_request['_id_gardu_index_existence_check']))
        {
            show_404();

            return false;
        }
        else
        {
            unset($this->callback_request['_id_gardu_index_existence_check']);
            $need_exist = isset($this->callback_request['_id_gardu_index_existence_check_need_exists']) ? $this->callback_request['_id_gardu_index_existence_check_need_exists'] : false;

            $this->load->model('model_gardu_index', 'mgidx');
            if ($this->mgidx->id_check($id))
            {
                if ($need_exist)
                {
                    return true;
                }
                else
                {
                    $this->form_validation->set_message('_id_gardu_index_existence_check', $this->lang->line('gardu_index_common_form_id_exists_error'));

                    return false;
                }
            }
            else
            {
                if ($need_exist)
                {
                    $this->form_validation->set_message('_id_gardu_index_existence_check', $this->lang->line('gardu_index_common_form_id_not_exists_error'));

                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }

    //==================================================================================================================

    public function pengukuran_index_register_post()
    {
        $this->load->library('session');
        $this->lang->load('layout/gardu/pengukuran/index/gardu_pengukuran_index_common', $this->language);

        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['no_gardu']        = $this->postOrDefault('no_gardu', null);
            $data['nama_petugas1']   = $this->postOrDefault('petugas1', $this->ion_auth->users_and_its_group('`users_groups`.`id`', $this->session->userdata('user_id'), $this->ion_auth->groupByName($this->session->userdata('group'))->row_array()['id'])->row_array()['id']);
            $data['nama_petugas2']   = $this->postOrDefault('petugas2', '');
            $data['no_kontrak']      = $this->postOrDefault('no_kontrak', '');
            $data['lat']             = $this->postOrDefault('lat', null);
            $data['lng']             = $this->postOrDefault('lng', null);
            $data['arus_R']          = $this->postOrDefault('ir', '');
            $data['arus_S']          = $this->postOrDefault('is', '');
            $data['arus_T']          = $this->postOrDefault('it', '');
            $data['arus_N']          = $this->postOrDefault('in', '');
            $data['teg_RN']          = $this->postOrDefault('vrn', '');
            $data['teg_SN']          = $this->postOrDefault('vsn', '');
            $data['teg_TN']          = $this->postOrDefault('vtn', '');
            $data['teg_RS']          = $this->postOrDefault('vrs', '');
            $data['teg_RT']          = $this->postOrDefault('vrt', '');
            $data['teg_ST']          = $this->postOrDefault('vst', '');
            $data['id_jurusan1']     = $this->postOrDefault('j_u1', '');
            $data['arus_R_jurusan1'] = $this->postOrDefault('ir_u1', '');
            $data['arus_S_jurusan1'] = $this->postOrDefault('is_u1', '');
            $data['arus_T_jurusan1'] = $this->postOrDefault('it_u1', '');
            $data['arus_N_jurusan1'] = $this->postOrDefault('in_u1', '');
            $data['teg_RN_jurusan1'] = $this->postOrDefault('vrn_u1', '');
            $data['teg_SN_jurusan1'] = $this->postOrDefault('vsn_u1', '');
            $data['teg_TN_jurusan1'] = $this->postOrDefault('vtn_u1', '');
            $data['teg_RS_jurusan1'] = $this->postOrDefault('vrs_u1', '');
            $data['teg_RT_jurusan1'] = $this->postOrDefault('vrt_u1', '');
            $data['teg_ST_jurusan1'] = $this->postOrDefault('vst_u1', '');
            $data['id_jurusan2']     = $this->postOrDefault('j_u2', '');
            $data['arus_R_jurusan2'] = $this->postOrDefault('ir_u2', '');
            $data['arus_S_jurusan2'] = $this->postOrDefault('is_u2', '');
            $data['arus_T_jurusan2'] = $this->postOrDefault('it_u2', '');
            $data['arus_N_jurusan2'] = $this->postOrDefault('in_u2', '');
            $data['teg_RN_jurusan2'] = $this->postOrDefault('vrn_u2', '');
            $data['teg_SN_jurusan2'] = $this->postOrDefault('vsn_u2', '');
            $data['teg_TN_jurusan2']  = $this->postOrDefault('vtn_u2', '');
            $data['teg_RS_jurusan2']  = $this->postOrDefault('vrs_u2', '');
            $data['teg_RT_jurusan2']  = $this->postOrDefault('vrt_u2', '');
            $data['teg_ST_jurusan2']  = $this->postOrDefault('vst_u2', '');
            $data['id_jurusan3']      = $this->postOrDefault('j_u3', '');
            $data['arus_R_jurusan3']  = $this->postOrDefault('ir_u3', '');
            $data['arus_S_jurusan3']  = $this->postOrDefault('is_u3', '');
            $data['arus_T_jurusan3']  = $this->postOrDefault('it_u3', '');
            $data['arus_N_jurusan3']  = $this->postOrDefault('in_u3', '');
            $data['teg_RN_jurusan3']  = $this->postOrDefault('vrn_u3', '');
            $data['teg_SN_jurusan3']  = $this->postOrDefault('vsn_u3', '');
            $data['teg_TN_jurusan3']  = $this->postOrDefault('vtn_u3', '');
            $data['teg_RS_jurusan3']  = $this->postOrDefault('vrs_u3', '');
            $data['teg_RT_jurusan3']  = $this->postOrDefault('vrt_u3', '');
            $data['teg_ST_jurusan3']  = $this->postOrDefault('vst_u3', '');
            $data['id_jurusan4']      = $this->postOrDefault('j_u4', '');
            $data['arus_R_jurusan4']  = $this->postOrDefault('ir_u4', '');
            $data['arus_S_jurusan4']  = $this->postOrDefault('is_u4', '');
            $data['arus_T_jurusan4']  = $this->postOrDefault('it_u4', '');
            $data['arus_N_jurusan4']  = $this->postOrDefault('in_u4', '');
            $data['teg_RN_jurusan4']  = $this->postOrDefault('vrn_u4', '');
            $data['teg_SN_jurusan4']  = $this->postOrDefault('vsn_u4', '');
            $data['teg_TN_jurusan4']  = $this->postOrDefault('vtn_u4', '');
            $data['teg_RS_jurusan4']  = $this->postOrDefault('vrs_u4', '');
            $data['teg_RT_jurusan4']  = $this->postOrDefault('vrt_u4', '');
            $data['teg_ST_jurusan4']  = $this->postOrDefault('vst_u4', '');
            $data['id_jurusank1']     = $this->postOrDefault('j_k1', '');
            $data['arus_R_jurusank1'] = $this->postOrDefault('ir_k1', '');
            $data['arus_S_jurusank1'] = $this->postOrDefault('is_k1', '');
            $data['arus_T_jurusank1'] = $this->postOrDefault('it_k1', '');
            $data['arus_N_jurusank1'] = $this->postOrDefault('in_k1', '');
            $data['teg_RN_jurusank1'] = $this->postOrDefault('vrn_k1', '');
            $data['teg_SN_jurusank1'] = $this->postOrDefault('vsn_k1', '');
            $data['teg_TN_jurusank1'] = $this->postOrDefault('vtn_k1', '');
            $data['teg_RS_jurusank1'] = $this->postOrDefault('vrs_k1', '');
            $data['teg_RT_jurusank1'] = $this->postOrDefault('vrt_k1', '');
            $data['teg_ST_jurusank1'] = $this->postOrDefault('vst_k1', '');
            $data['id_jurusank2']     = $this->postOrDefault('j_k2', '');
            $data['arus_R_jurusank2'] = $this->postOrDefault('ir_k2', '');
            $data['arus_S_jurusank2'] = $this->postOrDefault('is_k2', '');
            $data['arus_T_jurusank2'] = $this->postOrDefault('it_k2', '');
            $data['arus_N_jurusank2'] = $this->postOrDefault('in_k2', '');
            $data['teg_RN_jurusank2'] = $this->postOrDefault('vrn_k2', '');
            $data['teg_SN_jurusank2'] = $this->postOrDefault('vsn_k2', '');
            $data['teg_TN_jurusank2'] = $this->postOrDefault('vtn_k2', '');
            $data['teg_RS_jurusank2'] = $this->postOrDefault('vrs_k2', '');
            $data['teg_RT_jurusank2'] = $this->postOrDefault('vrt_k2', '');
            $data['teg_ST_jurusank2'] = $this->postOrDefault('vst_k2', '');

            $this->callback_request['_id_gardu_index_existence_check']             = true;
            $this->callback_request['_id_gardu_index_existence_check_need_exists'] = true;

            $this->form_validation->set_data($data);

            // validate form input
            $this->form_validation->set_rules('no_gardu', $this->lang->line('gardu_pengukuran_index_common_form_no_gardu_label'), 'required|callback__id_gardu_index_existence_check');

            $isValid = $this->form_validation->run();
            if ($isValid)
            {
                $this->load->model('model_gardu_index', 'mgidx');
                if ($this->mgidx->insert_measurement($data))
                {
                    $response['data']['status']                                   = 1;
                    $response['data']['message']['notify']['register']['success'] = [$this->lang->line('gardu_pengukuran_index_common_insert_success')];
                }
                else
                {
                    $response['data']['status']                                  = 0;
                    $response['data']['message']['notify']['register']['danger'] = [$this->lang->line('gardu_pengukuran_index_common_insert_failed')];
                }
            }
            else
            {
                $response['data']['status']                                  = 0;
                $response['data']['message']['notify']['validation']['info'] = $this->validation_errors();
            }
            $response['data']['csrf']['name'] = $this->security->get_csrf_token_name();
            $response['data']['csrf']['hash'] = $this->security->get_csrf_hash();
        }
        else
        {
            $response['data']['message']['notify']['register']['info'] = [$this->lang->line('gardu_pengukuran_index_common_creation_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }
}

?>

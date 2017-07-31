<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 30 July 2017, 9:25 AM.
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

    //==================================================================================================================

    /**
     *
     */
    public function induk_find_get()
    {
        /** @var array $response */
        $response = [];

        if ((!empty($_SERVER['HTTP_X_ACCESS_PERMISSION']) && !empty($_SERVER['HTTP_X_ACCESS_GUARD']) && !empty($_SERVER['HTTP_X_ACCESS_TOKEN']))
            && (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_PERMISSION']), $this->config->item('non_csrf_permission')) === 0)
            && (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_GUARD']), $this->config->item('non_csrf_guard')) === 0)
            && ($this->ion_auth->check_token($_SERVER['HTTP_X_ACCESS_TOKEN']))
        )
        {
            $code = $this->getOrDefault('code', '');
            switch ($code)
            {
                case 'C41AF' :
                {
                    //Must Be located on library preventing code redundancy
                    $response = array_merge($response, $this->get_all_gardu_induk());
                }
                break;
                default:
                {
                    $response['data']['status'] = 0;
                    $response['data']['message'] = array_merge([], $this->ion_auth->messages());
                    $response['data']['message'] = array_merge($response['data']['message'], $this->validation_errors());
                }
            }
        }
        else
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message'] = [$this->lang->line('user_get_forbidden')];
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

        $induk = $this->mgi->find("`datagarduinduk_tb`.`id_tb_gardu_induk` AS 'id', `datagarduinduk_tb`.`nama_gardu_induk` AS 'name'")->result_array();
        if (empty($induk))
        {
            $response['data']['gardu_induk'] = [];
        }
        else
        {
            $response['data']['gardu_induk'] = $induk;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    /**
     * @param int $id
     * @return bool|mixed
     */
    public function _id_gardu_induk_existence_check($id)
    {

        if (empty($this->callback_request['_id_gardu_induk_existence_check']))
        {
            return false;
        }
        else
        {
            unset($this->callback_request['_id_gardu_induk_existence_check']);
            $need_exist = isset($this->callback_request['_id_gardu_induk_existence_check_need_exists']) ? $this->callback_request['_id_gardu_induk_existence_check_need_exists'] : false;
            $id = intval($id);

            $this->load->model('model_gardu_induk', 'mgi');
            if ($this->mgi->id_check($id))
            {
                if ($need_exist)
                {
                    return true;
                }
                else
                {
                    $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);
                    $this->form_validation->set_message('_id_gardu_induk_existence_check', $this->lang->line('gardu_induk_common_form_id_exists_error'));

                    return false;
                }
            }
            else
            {
                if ($need_exist)
                {
                    $this->lang->load('layout/gardu/induk/gardu_induk_common', $this->language);
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

    //==================================================================================================================

    /**
     *
     */
    public function penyulang_find_get()
    {
        /** @var array $response */
        $response = [];

        if ((!empty($_SERVER['HTTP_X_ACCESS_PERMISSION']) && !empty($_SERVER['HTTP_X_ACCESS_GUARD']) && !empty($_SERVER['HTTP_X_ACCESS_TOKEN']))
            && (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_PERMISSION']), $this->config->item('non_csrf_permission')) === 0)
            && (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_GUARD']), $this->config->item('non_csrf_guard')) === 0)
            && ($this->ion_auth->check_token($_SERVER['HTTP_X_ACCESS_TOKEN']))
        )
        {
            $code = $this->getOrDefault('code', '');
            switch ($code)
            {
                case 'B28FE' :
                {
                    //Must Be located on library preventing code redundancy
                    $response = array_merge($response, $this->get_all_gardu_penyulang());
                }
                break;
                default:
                {
                    $response['data']['status'] = 0;
                    $response['data']['message'] = array_merge([], $this->ion_auth->messages());
                    $response['data']['message'] = array_merge($response['data']['message'], $this->validation_errors());
                }
            }
        }
        else
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message'] = [$this->lang->line('user_get_forbidden')];
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
     * @param int $id
     * @return bool|mixed
     */
    public function _id_gardu_penyulang_existence_check($id)
    {

        if (empty($this->callback_request['_id_gardu_penyulang_existence_check']))
        {
            return false;
        }
        else
        {
            unset($this->callback_request['_id_gardu_penyulang_existence_check']);
            $need_exist = isset($this->callback_request['_id_gardu_penyulang_existence_check_need_exists']) ? $this->callback_request['_id_gardu_penyulang_existence_check_need_exists'] : false;
            $id = intval($id);

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

    //==================================================================================================================

    /**
     *
     */
    public function index_register_post()
    {
        $this->language = empty($_GET['lang']) ? $this->config->item('language') : $_GET['lang'];

        /** @var array $response */
        $response = [];
        $response['data']['status'] = 0;

        if ((!empty($_SERVER['HTTP_X_ACCESS_PERMISSION']) && !empty($_SERVER['HTTP_X_ACCESS_GUARD']) && !empty($_SERVER['HTTP_X_ACCESS_TOKEN']))
            && (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_PERMISSION']), $this->config->item('non_csrf_permission')) === 0)
            && (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_GUARD']), $this->config->item('non_csrf_guard')) === 0)
            && ($this->ion_auth->check_token($_SERVER['HTTP_X_ACCESS_TOKEN']))
        )
        {
            $this->load->library('form_validation');

            /** @var array $data
             * @var string $identity_column
             */
            $data = [];

            $data['id_tb_gardu_induk'] = $this->postOrDefault('induk_id', null);
            $data['id_tb_gardu_penyulang'] = $this->postOrDefault('penyulang_id', null);
            $data['jns_gardu'] = $this->postOrDefault('jenis', null);
            $data['no_gardu'] = $this->postOrDefault('no', null);
            $data['lokasi'] = $this->postOrDefault('lokasi', null);
            $data['merk_trafo'] = $this->postOrDefault('merk', null);
            $data['no_seri_trafo'] = $this->postOrDefault('serial', null);
            $data['daya_trafo'] = $this->postOrDefault('daya', null);
            $data['fasa'] = $this->postOrDefault('fasa', null);
            $data['tap'] = $this->postOrDefault('tap', null);
            $data['jml_jurusan'] = $this->postOrDefault('jurusan', null);
            $data['latitude'] = $this->postOrDefault('lat', null);
            $data['longitude'] = $this->postOrDefault('long', null);

            $this->lang->load('layout/gardu/index/gardu_index_common', $this->language);

            $this->callback_request['_id_gardu_index_existence_check'] = true;
            $this->callback_request['_id_gardu_induk_existence_check'] = true;
            $this->callback_request['_id_gardu_penyulang_existence_check'] = true;
            $this->callback_request['_id_gardu_index_existence_check_need_exists'] = false;
            $this->callback_request['_id_gardu_induk_existence_check_need_exists'] = true;
            $this->callback_request['_id_gardu_penyulang_existence_check_need_exists'] = true;

            $this->form_validation->set_data($data);

            log_message('ERROR', var_export($data, true));
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
                    $response['data']['status'] = 1;
                    $response['data']['message'] = [$this->lang->line('gardu_index_common_insert_success')];
                }
                else
                {
                    $response['data']['status'] = 0;
                    $response['data']['message'] = [$this->lang->line('gardu_index_common_insert_failed')];
                }
            }
            else
            {
                $response['data']['status'] = 0;
                $response['data']['message'] = array_merge([], $this->validation_errors());
            }
        }
        else
        {
            $this->lang->load('ion_auth_extended', $this->language);

            $response['data']['message'] = [$this->lang->line('user_get_forbidden')];
        }


        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    public function _id_gardu_index_existence_check($id)
    {

        if (empty($this->callback_request['_id_gardu_index_existence_check']))
        {
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
                    $this->lang->load('layout/gardu/index/gardu_index_common', $this->language);
                    $this->form_validation->set_message('_id_gardu_index_existence_check', $this->lang->line('gardu_index_common_form_id_exists_error'));

                    return false;
                }
            }
            else
            {
                if ($need_exist)
                {
                    $this->lang->load('layout/gardu/index/gardu_index_common', $this->language);
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
}

?>

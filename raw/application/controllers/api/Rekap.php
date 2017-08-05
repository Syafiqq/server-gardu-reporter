<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 05 August 2017, 6:09 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

use Carbon\Carbon;

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/MY_REST_Controller.php';


/**
 * Class Rekap
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
 * @property Model_rekap_pengukuran mrp
 * @property MReport mReport
 */
class Rekap extends \Restserver\Libraries\MY_REST_Controller
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
    public function pengukuran_gardu_find_get()
    {
        /** @var array $response */
        $response = [];

        if ($this->ion_auth->logged_in())
        {
            $code = $this->getOrDefault('code', '');
            $from = $this->getOrDefault('from', null);
            $to   = $this->getOrDefault('to', null);
            if (!is_null($from))
            {
                try
                {
                    $from = Carbon::createFromFormat('Y-m-d', $from)->toDateString();;
                }
                catch (InvalidArgumentException $ignored)
                {
                    $from = null;
                }
            }
            if (!is_null($to))
            {
                try
                {
                    $to = Carbon::createFromFormat('Y-m-d', $to)->toDateString();;
                }
                catch (InvalidArgumentException $ignored)
                {
                    $to = null;
                }
            }
            switch ($code)
            {
                case '82AF2' :
                {
                    $response = array_merge($response, $this->_pengukuran_gardu_find_82AF2_get($from, $to));
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

    private function _pengukuran_gardu_find_82AF2_get($from = null, $to = null)
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_rekap_pengukuran', 'mrp');

        $rekap = $this->mrp->find_gardu("
            `id_ukur_gardu` AS 'id',
            `no_gardu` AS 'no_gardu',
            `nama_gardu_induk` AS 'gardu_induk',
            `nama_penyulang` AS 'gardu_penyulang',
            `lokasi` AS 'lokasi',
            `latitude` AS 'latitude',
            `longitude` AS 'longitude',
            `nama_petugas1` AS 'petugas_1',
            `nama_petugas2` AS 'petugas_2',
            `no_kontrak` AS 'no_kontrak',
            `tgl_pengukuran` AS 'date',
            `wkt_pengukuran` AS 'time',
            `arus_R` AS 'ir',
            `arus_S` AS 'is',
            `arus_T` AS 'it',
            `arus_N` AS 'in',
            `teg_RN` AS 'vrn',
            `teg_SN` AS 'vsn',
            `teg_TN` AS 'vtn',
            `teg_RS` AS 'vrs',
            `teg_RT` AS 'vrt',
            `teg_ST` AS 'vst',
            `id_jurusan1` AS 'id_u1',
            `arus_R_jurusan1` AS 'ir_u1',
            `arus_S_jurusan1` AS 'is_u1',
            `arus_T_jurusan1` AS 'it_u1',
            `arus_N_jurusan1` AS 'in_u1',
            `teg_RN_jurusan1` AS 'vrn_u1',
            `teg_SN_jurusan1` AS 'vsn_u1',
            `teg_TN_jurusan1` AS 'vtn_u1',
            `teg_RS_jurusan1` AS 'vrs_u1',
            `teg_RT_jurusan1` AS 'vrt_u1',
            `teg_ST_jurusan1` AS 'vst_u1',
            `id_jurusan2` AS 'id_u2',
            `arus_R_jurusan2` AS 'ir_u2',
            `arus_S_jurusan2` AS 'is_u2',
            `arus_T_jurusan2` AS 'it_u2',
            `arus_N_jurusan2` AS 'in_u2',
            `teg_RN_jurusan2` AS 'vrn_u2',
            `teg_SN_jurusan2` AS 'vsn_u2',
            `teg_TN_jurusan2` AS 'vtn_u2',
            `teg_RS_jurusan2` AS 'vrs_u2',
            `teg_RT_jurusan2` AS 'vrt_u2',
            `teg_ST_jurusan2` AS 'vst_u2',
            `id_jurusan3` AS 'id_u3',
            `arus_R_jurusan3` AS 'ir_u3',
            `arus_S_jurusan3` AS 'is_u3',
            `arus_T_jurusan3` AS 'it_u3',
            `arus_N_jurusan3` AS 'in_u3',
            `teg_RN_jurusan3` AS 'vrn_u3',
            `teg_SN_jurusan3` AS 'vsn_u3',
            `teg_TN_jurusan3` AS 'vtn_u3',
            `teg_RS_jurusan3` AS 'vrs_u3',
            `teg_RT_jurusan3` AS 'vrt_u3',
            `teg_ST_jurusan3` AS 'vst_u3',
            `id_jurusan4` AS 'id_u4',
            `arus_R_jurusan4` AS 'ir_u4',
            `arus_S_jurusan4` AS 'is_u4',
            `arus_T_jurusan4` AS 'it_u4',
            `arus_N_jurusan4` AS 'in_u4',
            `teg_RN_jurusan4` AS 'vrn_u4',
            `teg_SN_jurusan4` AS 'vsn_u4',
            `teg_TN_jurusan4` AS 'vtn_u4',
            `teg_RS_jurusan4` AS 'vrs_u4',
            `teg_RT_jurusan4` AS 'vrt_u4',
            `teg_ST_jurusan4` AS 'vst_u4',
            `id_jurusank1` AS 'id_k1',
            `arus_R_jurusank1` AS 'ir_k1',
            `arus_S_jurusank1` AS 'is_k1',
            `arus_T_jurusank1` AS 'it_k1',
            `arus_N_jurusank1` AS 'in_k1',
            `teg_RN_jurusank1` AS 'vrn_k1',
            `teg_SN_jurusank1` AS 'vsn_k1',
            `teg_TN_jurusank1` AS 'vtn_k1',
            `teg_RS_jurusank1` AS 'vrs_k1',
            `teg_RT_jurusank1` AS 'vrt_k1',
            `teg_ST_jurusank1` AS 'vst_k1',
            `id_jurusank2` AS 'id_k2',
            `arus_R_jurusank2` AS 'ir_k2',
            `arus_S_jurusank2` AS 'is_k2',
            `arus_T_jurusank2` AS 'it_k2',
            `arus_N_jurusank2` AS 'in_k2',
            `teg_RN_jurusank2` AS 'vrn_k2',
            `teg_SN_jurusank2` AS 'vsn_k2',
            `teg_TN_jurusank2` AS 'vtn_k2',
            `teg_RS_jurusank2` AS 'vrs_k2',
            `teg_RT_jurusank2` AS 'vrt_k2',
            `teg_ST_jurusank2` AS 'vst_k2',
            "
            , $from, $to)->result_array();
        if (empty($rekap))
        {
            $response['data']['rekap_pengukuran_gardu'] = [];
        }
        else
        {
            $response['data']['rekap_pengukuran_gardu'] = $rekap;
        }
        $response['data']['status'] = 1;

        return $response;

    }
}

?>

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
                    $to = Carbon::createFromFormat('Y-m-d', $to)->toDateString();
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

    public function pengukuran_gardu_download_get()
    {
        /** @var array $response */
        $response                   = [];
        $response['data']['status'] = 0;

        $this->lang->load("layout/rekap/pengukuran/gardu/rekap_pengukuran_gardu_common", $this->language);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $from = $this->getOrDefault('from', null);
            $to   = $this->getOrDefault('to', null);

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
            if (!empty($rekap))
            {
                $excel = new PHPExcel();

                // Set document properties
                $excel->getProperties()->setCreator("Eka Yuliana")
                    ->setLastModifiedBy("PLN Bali Selatan")
                    ->setTitle("Rekapitulasi Data Pengukuran Gardu")
                    ->setSubject("PLN")
                    ->setCategory("Rahasia");

                // Set lebar kolom
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(5);

                foreach (range('B', 'D') as $columnID)
                {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setWidth(20);
                }

                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);

                foreach (range('F', 'G') as $columnID)
                {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setWidth(18);
                }

                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(23);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(23);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);

                foreach (range('K', 'V') as $columnID)
                {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setWidth(18);
                }

                for ($col = 'W'; $col !== 'CK'; $col++)
                {
                    $excel->getActiveSheet()
                        ->getColumnDimension($col)
                        ->setAutoSize(true);
                }

                // Mergecell, menyatukan beberapa kolom
                $excel->setActiveSheetIndex(0)->mergeCells('A1:CJ1');
                $excel->setActiveSheetIndex(0)->mergeCells('A2:CJ2');
                $excel->setActiveSheetIndex(0)->mergeCells('A3:CJ3');

                $excel->setActiveSheetIndex(0)->mergeCells('A4:A5');
                $excel->setActiveSheetIndex(0)->mergeCells('B4:B5');
                $excel->setActiveSheetIndex(0)->mergeCells('C4:C5');
                $excel->setActiveSheetIndex(0)->mergeCells('D4:D5');
                $excel->setActiveSheetIndex(0)->mergeCells('E4:E5');
                $excel->setActiveSheetIndex(0)->mergeCells('F4:F5');
                $excel->setActiveSheetIndex(0)->mergeCells('G4:G5');
                $excel->setActiveSheetIndex(0)->mergeCells('H4:H5');
                $excel->setActiveSheetIndex(0)->mergeCells('I4:I5');
                $excel->setActiveSheetIndex(0)->mergeCells('J4:J5');
                $excel->setActiveSheetIndex(0)->mergeCells('K4:K5');
                $excel->setActiveSheetIndex(0)->mergeCells('L4:L5');
                $excel->setActiveSheetIndex(0)->mergeCells('M4:M5');
                $excel->setActiveSheetIndex(0)->mergeCells('N4:N5');
                $excel->setActiveSheetIndex(0)->mergeCells('O4:O5');
                $excel->setActiveSheetIndex(0)->mergeCells('P4:P5');
                $excel->setActiveSheetIndex(0)->mergeCells('Q4:Q5');
                $excel->setActiveSheetIndex(0)->mergeCells('R4:R5');
                $excel->setActiveSheetIndex(0)->mergeCells('S4:S5');
                $excel->setActiveSheetIndex(0)->mergeCells('T4:T5');
                $excel->setActiveSheetIndex(0)->mergeCells('U4:U5');
                $excel->setActiveSheetIndex(0)->mergeCells('V4:V5');

                $excel->setActiveSheetIndex(0)->mergeCells('W4:AG4');
                $excel->setActiveSheetIndex(0)->mergeCells('AH4:AR4');
                $excel->setActiveSheetIndex(0)->mergeCells('AS4:BC4');
                $excel->setActiveSheetIndex(0)->mergeCells('BD4:BN4');
                $excel->setActiveSheetIndex(0)->mergeCells('BO4:BY4');
                $excel->setActiveSheetIndex(0)->mergeCells('BZ4:CJ4');

                //Mengeset Style nya
                $titlestyle  = new PHPExcel_Style();
                $headerstyle = new PHPExcel_Style();
                $bodystyle   = new PHPExcel_Style();

                //setting title style
                $titlestyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ));

                //setting header style
                $headerstyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('argb' => 'FFEEEEEE')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                        'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                //setting body style
                $bodystyle->applyFromArray(
                    array('fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('argb' => 'FFFFFFFF')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                        'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                // mulai dari baris ke 4
                $row = 4;
                //anak judul tabel
                $row2 = 5;

                if (!is_null($from) && !is_null($to))
                {
                    $tglstart = Carbon::createFromFormat('Y-m-d', $from)->formatLocalized('%d %B %Y');
                    $tglend   = Carbon::createFromFormat('Y-m-d', $to)->formatLocalized('%d %B %Y');

                    $rentang = 'Pada Tanggal ' . $tglstart . ' s/d ' . $tglend;
                }
                else
                {
                    $rentang = '';
                }

                // Tulis judul tabel
                $excel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'PT. PLN (Persero) Area Bali Selatan')
                    ->setCellValue('A2', 'REKAPITULASI DATA PENGUKURAN GARDU')
                    ->setCellValue('A3', $rentang)
                    ->setCellValue('A' . $row, 'No')
                    ->setCellValue('B' . $row, 'No. Gardu')
                    ->setCellValue('C' . $row, 'Gardu Induk')
                    ->setCellValue('D' . $row, 'Penyulang')
                    ->setCellValue('E' . $row, 'Lokasi')
                    ->setCellValue('F' . $row, 'Latitude')
                    ->setCellValue('G' . $row, 'Longitude')
                    ->setCellValue('H' . $row, 'Nama Petugas 1')
                    ->setCellValue('I' . $row, 'Nama Petugas 2')
                    ->setCellValue('J' . $row, 'No. Kontrak')
                    ->setCellValue('K' . $row, 'Tgl Pengukuran')
                    ->setCellValue('L' . $row, 'Waktu Pengukuran')
                    ->setCellValue('M' . $row, 'Arus R')
                    ->setCellValue('N' . $row, 'Arus S')
                    ->setCellValue('O' . $row, 'Arus T')
                    ->setCellValue('P' . $row, 'Arus N')
                    ->setCellValue('Q' . $row, 'Tegangan RN')
                    ->setCellValue('R' . $row, 'Tegangan SN')
                    ->setCellValue('S' . $row, 'Tegangan TN')
                    ->setCellValue('T' . $row, 'Tegangan RS')
                    ->setCellValue('U' . $row, 'Tegangan RT')
                    ->setCellValue('V' . $row, 'Tegangan ST')
                    ->setCellValue('W' . $row, 'Jurusan 1')
                    ->setCellValue('AH' . $row, 'Jurusan 2')
                    ->setCellValue('AS' . $row, 'Jurusan 3')
                    ->setCellValue('BD' . $row, 'Jurusan 4')
                    ->setCellValue('BO' . $row, 'Jurusan Khusus 1')
                    ->setCellValue('BZ' . $row, 'Jurusan Khusus 2')
                    // jurusan 1
                    ->setCellValue('W' . $row2, 'ID Jurusan')
                    ->setCellValue('X' . $row2, 'Arus R')
                    ->setCellValue('Y' . $row2, 'Arus S')
                    ->setCellValue('Z' . $row2, 'Arus T')
                    ->setCellValue('AA' . $row2, 'Arus N')
                    ->setCellValue('AB' . $row2, 'Tegangan RN')
                    ->setCellValue('AC' . $row2, 'Tegangan SN')
                    ->setCellValue('AD' . $row2, 'Tegangan TN')
                    ->setCellValue('AE' . $row2, 'Tegangan RS')
                    ->setCellValue('AF' . $row2, 'Tegangan RT')
                    ->setCellValue('AG' . $row2, 'Tegangan ST')
                    // jurusan 2
                    ->setCellValue('AH' . $row2, 'ID Jurusan')
                    ->setCellValue('AI' . $row2, 'Arus R')
                    ->setCellValue('AJ' . $row2, 'Arus S')
                    ->setCellValue('AK' . $row2, 'Arus T')
                    ->setCellValue('AL' . $row2, 'Arus N')
                    ->setCellValue('AM' . $row2, 'Tegangan RN')
                    ->setCellValue('AN' . $row2, 'Tegangan SN')
                    ->setCellValue('AO' . $row2, 'Tegangan TN')
                    ->setCellValue('AP' . $row2, 'Tegangan RS')
                    ->setCellValue('AQ' . $row2, 'Tegangan RT')
                    ->setCellValue('AR' . $row2, 'Tegangan ST')
                    // jurusan 3
                    ->setCellValue('AS' . $row2, 'ID Jurusan')
                    ->setCellValue('AT' . $row2, 'Arus R')
                    ->setCellValue('AU' . $row2, 'Arus S')
                    ->setCellValue('AV' . $row2, 'Arus T')
                    ->setCellValue('AW' . $row2, 'Arus N')
                    ->setCellValue('AX' . $row2, 'Tegangan RN')
                    ->setCellValue('AY' . $row2, 'Tegangan SN')
                    ->setCellValue('AZ' . $row2, 'Tegangan TN')
                    ->setCellValue('BA' . $row2, 'Tegangan RS')
                    ->setCellValue('BB' . $row2, 'Tegangan RT')
                    ->setCellValue('BC' . $row2, 'Tegangan ST')
                    // jurusan 4
                    ->setCellValue('BD' . $row2, 'ID Jurusan')
                    ->setCellValue('BE' . $row2, 'Arus R')
                    ->setCellValue('BF' . $row2, 'Arus S')
                    ->setCellValue('BG' . $row2, 'Arus T')
                    ->setCellValue('BH' . $row2, 'Arus N')
                    ->setCellValue('BI' . $row2, 'Tegangan RN')
                    ->setCellValue('BJ' . $row2, 'Tegangan SN')
                    ->setCellValue('BK' . $row2, 'Tegangan TN')
                    ->setCellValue('BL' . $row2, 'Tegangan RS')
                    ->setCellValue('BM' . $row2, 'Tegangan RT')
                    ->setCellValue('BN' . $row2, 'Tegangan ST')
                    // jurusan khusus 1
                    ->setCellValue('BO' . $row2, 'ID Jurusan')
                    ->setCellValue('BP' . $row2, 'Arus R')
                    ->setCellValue('BQ' . $row2, 'Arus S')
                    ->setCellValue('BR' . $row2, 'Arus T')
                    ->setCellValue('BS' . $row2, 'Arus N')
                    ->setCellValue('BT' . $row2, 'Tegangan RN')
                    ->setCellValue('BU' . $row2, 'Tegangan SN')
                    ->setCellValue('BV' . $row2, 'Tegangan TN')
                    ->setCellValue('BW' . $row2, 'Tegangan RS')
                    ->setCellValue('BX' . $row2, 'Tegangan RT')
                    ->setCellValue('BY' . $row2, 'Tegangan ST')
                    // jurusan khusus 2
                    ->setCellValue('BZ' . $row2, 'ID Jurusan')
                    ->setCellValue('CA' . $row2, 'Arus R')
                    ->setCellValue('CB' . $row2, 'Arus S')
                    ->setCellValue('CC' . $row2, 'Arus T')
                    ->setCellValue('CD' . $row2, 'Arus N')
                    ->setCellValue('CE' . $row2, 'Tegangan RN')
                    ->setCellValue('CF' . $row2, 'Tegangan SN')
                    ->setCellValue('CG' . $row2, 'Tegangan TN')
                    ->setCellValue('CH' . $row2, 'Tegangan RS')
                    ->setCellValue('CI' . $row2, 'Tegangan RT')
                    ->setCellValue('CJ' . $row2, 'Tegangan ST');

                //Menggunakan TitleStylenya
                $excel->getActiveSheet()->setSharedStyle($titlestyle, "A1:CJ3");

                //Menggunakan HeaderStylenya
                $excel->getActiveSheet()->setSharedStyle($headerstyle, "A4:CJ5");

                $nomor = 1; // set nomor urut = 1;

                $row2++; // pindah ke row bawahnya.

                // lakukan perulangan untuk menuliskan data siswa
                setlocale(LC_TIME, 'Indonesian');
                Carbon::setLocale('id');
                foreach ($rekap as $key => $content)
                {
                    $tgl = Carbon::createFromFormat('Y-m-d', $content['date'])->formatLocalized('%d %B %Y');
                    $wkt = Carbon::createFromFormat('H:i:s', $content['time'])->formatLocalized('%H:%M:%S');

                    $excel->setActiveSheetIndex(0)
                        ->setCellValueExplicit('A' . $row2, $nomor, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('B' . $row2, $content['no_gardu'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('C' . $row2, $content['gardu_induk'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D' . $row2, $content['gardu_penyulang'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('E' . $row2, $content['lokasi'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('F' . $row2, $content['latitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('G' . $row2, $content['longitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('H' . $row2, $content['petugas_1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('I' . $row2, $content['petugas_2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('J' . $row2, $content['no_kontrak'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('K' . $row2, $tgl, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('L' . $row2, $wkt, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('M' . $row2, $content['ir'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('N' . $row2, $content['is'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('O' . $row2, $content['it'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('P' . $row2, $content['in'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('Q' . $row2, $content['vrn'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('R' . $row2, $content['vsn'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('S' . $row2, $content['vtn'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('T' . $row2, $content['vrs'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('U' . $row2, $content['vrt'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('V' . $row2, $content['vst'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('W' . $row2, $content['id_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('X' . $row2, $content['ir_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('Y' . $row2, $content['is_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('Z' . $row2, $content['it_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AA' . $row2, $content['in_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AB' . $row2, $content['vrn_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AC' . $row2, $content['vsn_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AD' . $row2, $content['vtn_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AE' . $row2, $content['vrs_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AF' . $row2, $content['vrt_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AG' . $row2, $content['vst_u1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AH' . $row2, $content['id_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AI' . $row2, $content['ir_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AJ' . $row2, $content['is_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AK' . $row2, $content['it_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AL' . $row2, $content['in_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AM' . $row2, $content['vrn_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AN' . $row2, $content['vsn_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AO' . $row2, $content['vtn_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AP' . $row2, $content['vrs_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AQ' . $row2, $content['vrt_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AR' . $row2, $content['vst_u2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AS' . $row2, $content['id_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AT' . $row2, $content['ir_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AU' . $row2, $content['is_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AV' . $row2, $content['it_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AW' . $row2, $content['in_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AX' . $row2, $content['vrn_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AY' . $row2, $content['vsn_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('AZ' . $row2, $content['vtn_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BA' . $row2, $content['vrs_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BB' . $row2, $content['vrt_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BC' . $row2, $content['vst_u3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BD' . $row2, $content['id_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BE' . $row2, $content['ir_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BF' . $row2, $content['is_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BG' . $row2, $content['it_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BH' . $row2, $content['in_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BI' . $row2, $content['vrn_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BJ' . $row2, $content['vsn_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BK' . $row2, $content['vtn_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BL' . $row2, $content['vrs_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BM' . $row2, $content['vrt_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BN' . $row2, $content['vst_u4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BO' . $row2, $content['id_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BP' . $row2, $content['ir_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BQ' . $row2, $content['is_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BR' . $row2, $content['it_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BS' . $row2, $content['in_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BT' . $row2, $content['vrn_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BU' . $row2, $content['vsn_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BV' . $row2, $content['vtn_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BW' . $row2, $content['vrs_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BX' . $row2, $content['vrt_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BY' . $row2, $content['vst_k1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('BZ' . $row2, $content['id_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CA' . $row2, $content['ir_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CB' . $row2, $content['is_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CC' . $row2, $content['it_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CD' . $row2, $content['in_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CE' . $row2, $content['vrn_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CF' . $row2, $content['vsn_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CG' . $row2, $content['vtn_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CH' . $row2, $content['vrs_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CI' . $row2, $content['vrt_k2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('CJ' . $row2, $content['vst_k2'], PHPExcel_Cell_DataType::TYPE_STRING);

                    $row2++; // pindah ke row bawahnya ($row2 + 1)
                    $nomor++;
                }

                //Membuat garis di body tabel (isi data)
                $excel->getActiveSheet()->setSharedStyle($bodystyle, "A6:CJ$row2");

                // Set sheet yang aktif adalah index pertama, jadi saat dibuka akan langsung fokus ke sheet pertama
                $excel->setActiveSheetIndex(0);
                // Mencetak File Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                if (!is_null($from) && !is_null($to))
                {
                    $_filename = "rekap-ukurgardu-trafo_$from-to-$to.xlsx";
                }
                else
                {
                    $_filename = "rekap-ukurgardu-trafo.xlsx";
                }
                header("Content-Disposition: attachment;filename=$_filename");
                header('Cache-Control: max-age=0');
                $objWriter = new PHPExcel_Writer_Excel5($excel);
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $response['data']['download']['content']  = "data:application/vnd.ms-excel;base64," . base64_encode($xlsData);
                $response['data']['download']['filename'] = $_filename;
            }
            $response['data']['status'] = 1;
        }
        else
        {
            $response['data']['message']['message']['download']['info'] = [$this->lang->line('rekap_pengukuran_gardu_common_download_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function pengukuran_tegangan_ujung_find_get()
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
                    $to = Carbon::createFromFormat('Y-m-d', $to)->toDateString();
                }
                catch (InvalidArgumentException $ignored)
                {
                    $to = null;
                }
            }
            switch ($code)
            {
                case '39A74' :
                {
                    $response = array_merge($response, $this->_pengukuran_tegangan_ujung_find_39A74_get($from, $to));
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

    private function _pengukuran_tegangan_ujung_find_39A74_get($from = null, $to = null)
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_rekap_pengukuran', 'mrp');

        $rekap = $this->mrp->find_tegangan_ujung("
            `id_ukur_gardu`     AS 'id',
            `no_gardu`          AS 'no_gardu',
            `nama_gardu_induk`  AS 'gardu_induk',
            `nama_penyulang`    AS 'gardu_penyulang',
            `lokasi`            AS 'lokasi',      
            `latitude`          AS 'latitude',
            `longitude`         AS 'longitude',
            `tgl_pengukuran`    AS 'date',
            `wkt_pengukuran`    AS 'time',
            `Stat_TUJurusan1`   AS 'umum_1',
            `Stat_TUJurusan2`   AS 'umum_2',
            `Stat_TUJurusan3`   AS 'umum_3',
            `Stat_TUJurusan4`   AS 'umum_4',
            `Stat_TUJurusank1`  AS 'khusus_1',
            `Stat_TUJurusank2`  AS 'khusus_2'
            "
            , $from, $to)->result_array();
        if (empty($rekap))
        {
            $response['data']['rekap_pengukuran_tegangan_ujung'] = [];
        }
        else
        {
            $response['data']['rekap_pengukuran_tegangan_ujung'] = $rekap;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    public function pengukuran_tegangan_ujung_download_get()
    {
        /** @var array $response */
        $response                   = [];
        $response['data']['status'] = 0;

        $this->lang->load("layout/rekap/pengukuran/tegangan/ujung/rekap_pengukuran_tegangan_ujung_common", $this->language);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $from = $this->getOrDefault('from', null);
            $to   = $this->getOrDefault('to', null);

            $this->load->model('model_rekap_pengukuran', 'mrp');

            $rekap = $this->mrp->find_tegangan_ujung("
            `id_ukur_gardu`     AS 'id',
            `no_gardu`          AS 'no_gardu',
            `nama_gardu_induk`  AS 'gardu_induk',
            `nama_penyulang`    AS 'gardu_penyulang',
            `lokasi`            AS 'lokasi',      
            `latitude`          AS 'latitude',
            `longitude`         AS 'longitude',
            `tgl_pengukuran`    AS 'date',
            `wkt_pengukuran`    AS 'time',
            `Stat_TUJurusan1`   AS 'umum_1',
            `Stat_TUJurusan2`   AS 'umum_2',
            `Stat_TUJurusan3`   AS 'umum_3',
            `Stat_TUJurusan4`   AS 'umum_4',
            `Stat_TUJurusank1`  AS 'khusus_1',
            `Stat_TUJurusank2`  AS 'khusus_2'
            "
                , $from, $to)->result_array();
            if (!empty($rekap))
            {
                $excel = new PHPExcel();

                // Set document properties
                $excel->getProperties()->setCreator("Eka Yuliana")
                    ->setLastModifiedBy("PLN Bali Selatan")
                    ->setTitle("Rekapitulasi Tegangan Ujung")
                    ->setSubject("PLN")
                    ->setCategory("Rahasia");

                // Set lebar kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(18);

                // Mergecell, menyatukan beberapa kolom
                $excel->setActiveSheetIndex(0)->mergeCells('A1:O1');
                $excel->setActiveSheetIndex(0)->mergeCells('A2:O2');
                $excel->setActiveSheetIndex(0)->mergeCells('A3:O3');

                $excel->setActiveSheetIndex(0)->mergeCells('A4:A5');
                $excel->setActiveSheetIndex(0)->mergeCells('B4:B5');
                $excel->setActiveSheetIndex(0)->mergeCells('C4:C5');
                $excel->setActiveSheetIndex(0)->mergeCells('D4:D5');
                $excel->setActiveSheetIndex(0)->mergeCells('E4:E5');
                $excel->setActiveSheetIndex(0)->mergeCells('F4:F5');
                $excel->setActiveSheetIndex(0)->mergeCells('G4:G5');
                $excel->setActiveSheetIndex(0)->mergeCells('H4:H5');
                $excel->setActiveSheetIndex(0)->mergeCells('I4:I5');

                $excel->setActiveSheetIndex(0)->mergeCells('J4:O4');

                //Mengeset Style nya
                $titlestyle  = new PHPExcel_Style();
                $headerstyle = new PHPExcel_Style();
                $bodystyle   = new PHPExcel_Style();

                //setting title style
                $titlestyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ));

                //setting header style
                $headerstyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('argb' => 'FFEEEEEE')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
                        'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                //setting body style
                $bodystyle->applyFromArray(
                    array('fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('argb' => 'FFFFFFFF')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                        'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                // mulai dari baris ke 4
                $row = 4;
                //anak judul tabel
                $row2 = 5;

                if (!is_null($from) && !is_null($to))
                {
                    $tglstart = Carbon::createFromFormat('Y-m-d', $from)->formatLocalized('%d %B %Y');
                    $tglend   = Carbon::createFromFormat('Y-m-d', $to)->formatLocalized('%d %B %Y');

                    $rentang = 'Berdasarkan Data Pengukuran Gardu pada Tanggal ' . $tglstart . ' s/d ' . $tglend;
                }
                else
                {
                    $rentang = 'Berdasarkan Data Pengukuran Gardu';
                }

                // Tulis judul tabel   
                $excel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'PT. PLN (Persero) Area Bali Selatan')
                    ->setCellValue('A2', 'REKAPITULASI TEGANGAN UJUNG')
                    ->setCellValue('A3', $rentang)
                    ->setCellValue('A' . $row, 'No')
                    ->setCellValue('B' . $row, 'No. Gardu')
                    ->setCellValue('C' . $row, 'Gardu Induk')
                    ->setCellValue('D' . $row, 'Penyulang')
                    ->setCellValue('E' . $row, 'Lokasi')
                    ->setCellValue('F' . $row, 'Latitude')
                    ->setCellValue('G' . $row, 'Longitude')
                    ->setCellValue('H' . $row, 'Tgl Pengukuran')
                    ->setCellValue('I' . $row, 'Waktu Pengukuran')
                    ->setCellValue('J' . $row, 'Status Tegangan Ujung')
                    ->setCellValue('J' . $row2, 'Jurusan 1')
                    ->setCellValue('K' . $row2, 'Jurusan 2')
                    ->setCellValue('L' . $row2, 'Jurusan 3')
                    ->setCellValue('M' . $row2, 'Jurusan 4')
                    ->setCellValue('N' . $row2, 'Jurusan Khusus 1')
                    ->setCellValue('O' . $row2, 'Jurusan Khusus 2');

                //Menggunakan TitleStylenya
                $excel->getActiveSheet()->setSharedStyle($titlestyle, "A1:O3");

                //Menggunakan HeaderStylenya
                $excel->getActiveSheet()->setSharedStyle($headerstyle, "A4:O5");

                $nomor = 1; // set nomor urut = 1;

                $row2++; // pindah ke row bawahnya. 

                // lakukan perulangan untuk menuliskan data siswa
                foreach ($rekap as $key => $content)
                {
                    $tgl = Carbon::createFromFormat('Y-m-d', $content['date'])->formatLocalized('%d %B %Y');
                    $wkt = Carbon::createFromFormat('H:i:s', $content['time'])->formatLocalized('%H:%M:%S');

                    $excel->setActiveSheetIndex(0)
                        ->setCellValueExplicit('A' . $row2, $nomor, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('B' . $row2, $content['no_gardu'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('C' . $row2, $content['gardu_induk'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D' . $row2, $content['gardu_penyulang'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('E' . $row2, $content['lokasi'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('F' . $row2, $content['latitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('G' . $row2, $content['longitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('H' . $row2, $tgl, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('I' . $row2, $wkt, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('J' . $row2, $content['umum_1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('K' . $row2, $content['umum_2'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('L' . $row2, $content['umum_3'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('M' . $row2, $content['umum_4'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('N' . $row2, $content['khusus_1'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('O' . $row2, $content['khusus_2'], PHPExcel_Cell_DataType::TYPE_STRING);

                    $row2++; // pindah ke row bawahnya ($row2 + 1)
                    $nomor++;
                }

                //Membuat garis di body tabel (isi data)
                $excel->getActiveSheet()->setSharedStyle($bodystyle, "A6:O$row2");

                // Set sheet yang aktif adalah index pertama, jadi saat dibuka akan langsung fokus ke sheet pertama
                $excel->setActiveSheetIndex(0);

                // Mencetak File Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                if (!is_null($from) && !is_null($to))
                {
                    $_filename = "rekap-teg-ujung_$from-to-$to.xlsx";
                }
                else
                {
                    $_filename = "rekap-teg-ujung.xlsx";
                }
                header("Content-Disposition: attachment;filename=$_filename");
                header('Cache-Control: max-age=0');

                $objWriter = new PHPExcel_Writer_Excel5($excel);
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $response['data']['download']['content']  = "data:application/vnd.ms-excel;base64," . base64_encode($xlsData);
                $response['data']['download']['filename'] = $_filename;
            }
            $response['data']['status'] = 1;
        }
        else
        {
            $response['data']['message']['message']['download']['info'] = [$this->lang->line('rekap_pengukuran_tegangan_ujung_common_download_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function pengukuran_beban_trafo_find_get()
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
                }
            }
            if (!is_null($to))
            {
                try
                {
                    $to = Carbon::createFromFormat('Y-m-d', $to)->toDateString();
                }
                catch (InvalidArgumentException $ignored)
                {
                }
            }
            switch ($code)
            {
                case '5AB23' :
                {
                    $response = array_merge($response, $this->_pengukuran_beban_trafo_find_5AB23_get($from, $to));
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

    private function _pengukuran_beban_trafo_find_5AB23_get($from = null, $to = null)
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_rekap_pengukuran', 'mrp');

        $rekap = $this->mrp->find_beban_trafo("
            `id_ukur_gardu`    AS 'no'              ,
            `no_gardu`         AS 'no_gardu'        ,
            `nama_gardu_induk` AS 'gardu_induk'     ,
            `nama_penyulang`   AS 'gardu_penyulang' ,
            `lokasi`           AS 'lokasi'          ,
            `latitude`         AS 'latitude'        ,
            `longitude`        AS 'longitude'       ,
            `tgl_pengukuran`   AS 'date'            ,
            `wkt_pengukuran`   AS 'time'            ,
            `daya_trafo`       AS 'f'               ,
            `arus_R`           AS 'ir'              ,
            `arus_S`           AS 'is'              ,
            `arus_T`           AS 'it'              ,
            `teg_RN`           AS 'vrn'             ,
            `teg_SN`           AS 'vsn'             ,
            `teg_TN`           AS 'vtn'             ,
            `beban_trafo`      AS 'w'               ,
            `prosen_beban`     AS 'percent'         ,
            `status_gardu`     AS 'status'          
            "
            , $from, $to)->result_array();
        if (empty($rekap))
        {
            $response['data']['rekap_pengukuran_beban_trafo'] = [];
        }
        else
        {
            $response['data']['rekap_pengukuran_beban_trafo'] = $rekap;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    public function pengukuran_beban_trafo_download_get()
    {
        /** @var array $response */
        $response                   = [];
        $response['data']['status'] = 0;

        $this->lang->load("layout/rekap/pengukuran/beban/trafo/rekap_pengukuran_beban_trafo_common", $this->language);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $from = $this->getOrDefault('from', null);
            $to   = $this->getOrDefault('to', null);

            $this->load->model('model_rekap_pengukuran', 'mrp');

            $rekap = $this->mrp->find_beban_trafo("
            `id_ukur_gardu`    AS 'no'              ,
            `no_gardu`         AS 'no_gardu'        ,
            `nama_gardu_induk` AS 'gardu_induk'     ,
            `nama_penyulang`   AS 'gardu_penyulang' ,
            `lokasi`           AS 'lokasi'          ,
            `latitude`         AS 'latitude'        ,
            `longitude`        AS 'longitude'       ,
            `tgl_pengukuran`   AS 'date'            ,
            `wkt_pengukuran`   AS 'time'            ,
            `daya_trafo`       AS 'f'               ,
            `arus_R`           AS 'ir'              ,
            `arus_S`           AS 'is'              ,
            `arus_T`           AS 'it'              ,
            `teg_RN`           AS 'vrn'             ,
            `teg_SN`           AS 'vsn'             ,
            `teg_TN`           AS 'vtn'             ,
            `beban_trafo`      AS 'w'               ,
            `prosen_beban`     AS 'percent'         ,
            `status_gardu`     AS 'status'          
            "
                , $from, $to)->result_array();
            if (!empty($rekap))
            {
                $excel = new PHPExcel();

                // Set document properties
                $excel->getProperties()->setCreator("Eka Yuliana")
                    ->setLastModifiedBy("PLN Bali Selatan")
                    ->setTitle("Rekapitulasi Beban Trafo")
                    ->setSubject("PLN")
                    ->setCategory("Rahasia");

                // Set lebar kolom
                foreach (range('A', 'S') as $columnID)
                {
                    $excel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
                }

                // Mergecell, menyatukan beberapa kolom
                $excel->setActiveSheetIndex(0)->mergeCells('A1:S1');
                $excel->setActiveSheetIndex(0)->mergeCells('A2:S2');
                $excel->setActiveSheetIndex(0)->mergeCells('A3:S3');

                //Mengeset Style nya
                $titlestyle  = new PHPExcel_Style();
                $headerstyle = new PHPExcel_Style();
                $bodystyle   = new PHPExcel_Style();

                //setting title style
                $titlestyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ));

                //setting header style
                $headerstyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('argb' => 'FFEEEEEE')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                        'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                //setting body style
                $bodystyle->applyFromArray(
                    array('fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('argb' => 'FFFFFFFF')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                        'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                // mulai dari baris ke 4
                $row = 4;

                if (!is_null($from) && !is_null($to))
                {
                    $tglstart = Carbon::createFromFormat('Y-m-d', $from)->formatLocalized('%d %B %Y');
                    $tglend   = Carbon::createFromFormat('Y-m-d', $to)->formatLocalized('%d %B %Y');

                    $rentang = 'Berdasarkan Data Pengukuran Gardu pada Tanggal ' . $tglstart . ' s/d ' . $tglend;
                }
                else
                {
                    $rentang = 'Berdasarkan Data Pengukuran Gardu';
                }

                // Tulis judul tabel   
                $excel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'PT. PLN (Persero) Area Bali Selatan')
                    ->setCellValue('A2', 'REKAPITULASI BEBAN TRAFO')
                    ->setCellValue('A3', $rentang)
                    ->setCellValue('A' . $row, 'No')
                    ->setCellValue('B' . $row, 'No. Gardu')
                    ->setCellValue('C' . $row, 'Gardu Induk')
                    ->setCellValue('D' . $row, 'Penyulang')
                    ->setCellValue('E' . $row, 'Lokasi')
                    ->setCellValue('F' . $row, 'Latitude')
                    ->setCellValue('G' . $row, 'Longitude')
                    ->setCellValue('H' . $row, 'Tgl Pengukuran')
                    ->setCellValue('I' . $row, 'Waktu Pengukuran')
                    ->setCellValue('J' . $row, 'Daya Trafo')
                    ->setCellValue('K' . $row, 'Arus R')
                    ->setCellValue('L' . $row, 'Arus S')
                    ->setCellValue('M' . $row, 'Arus T')
                    ->setCellValue('N' . $row, 'Tegangan RN')
                    ->setCellValue('O' . $row, 'Tegangan SN')
                    ->setCellValue('P' . $row, 'Tegangan TN')
                    ->setCellValue('Q' . $row, 'Beban Trafo')
                    ->setCellValue('R' . $row, 'Prosen Beban')
                    ->setCellValue('S' . $row, 'Status gardu');

                //Menggunakan TitleStylenya
                $excel->getActiveSheet()->setSharedStyle($titlestyle, "A1:S3");

                //Menggunakan HeaderStylenya
                $excel->getActiveSheet()->setSharedStyle($headerstyle, "A4:S4");

                $nomor = 1; // set nomor urut = 1;

                $row++; // pindah ke row bawahnya. 

                // lakukan perulangan untuk menuliskan data siswa
                foreach ($rekap as $key => $content)
                {
                    $tgl = Carbon::createFromFormat('Y-m-d', $content['date'])->formatLocalized('%d %B %Y');
                    $wkt = Carbon::createFromFormat('H:i:s', $content['time'])->formatLocalized('%H:%M:%S');

                    $excel->setActiveSheetIndex(0)
                        ->setCellValueExplicit('A' . $row, $nomor, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('B' . $row, $content['no_gardu'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('C' . $row, $content['gardu_induk'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D' . $row, $content['gardu_penyulang'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('E' . $row, $content['lokasi'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('F' . $row, $content['latitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('G' . $row, $content['longitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('H' . $row, $tgl, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('I' . $row, $wkt, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('J' . $row, $content['f'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('K' . $row, $content['ir'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('L' . $row, $content['is'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('M' . $row, $content['it'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('N' . $row, $content['vrn'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('O' . $row, $content['vsn'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('P' . $row, $content['vtn'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('Q' . $row, $content['w'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('R' . $row, $content['percent'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('S' . $row, $content['status'], PHPExcel_Cell_DataType::TYPE_STRING);

                    $row++; // pindah ke row bawahnya ($row + 1)
                    $nomor++;
                }

                //Membuat garis di body tabel (isi data)
                $excel->getActiveSheet()->setSharedStyle($bodystyle, "A5:S$row");

                // Set sheet yang aktif adalah index pertama, jadi saat dibuka akan langsung fokus ke sheet pertama
                $excel->setActiveSheetIndex(0);

                // Mencetak File Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                if (!is_null($from) && !is_null($to))
                {
                    $_filename = "rekap-bbngardu-trafo_$from-to-$to.xlsx";
                }
                else
                {
                    $_filename = "rekap-bbngardu-trafo.xlsx";
                }
                header("Content-Disposition: attachment;filename=$_filename");
                header('Cache-Control: max-age=0');

                $objWriter = new PHPExcel_Writer_Excel5($excel);
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $response['data']['download']['content']  = "data:application/vnd.ms-excel;base64," . base64_encode($xlsData);
                $response['data']['download']['filename'] = $_filename;
            }
            $response['data']['status'] = 1;
        }
        else
        {
            $response['data']['message']['message']['download']['info'] = [$this->lang->line('rekap_pengukuran_beban_trafo_common_download_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }

    /**
     *
     */
    public function pengukuran_beban_imbang_find_get()
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
                }
            }
            if (!is_null($to))
            {
                try
                {
                    $to = Carbon::createFromFormat('Y-m-d', $to)->toDateString();
                }
                catch (InvalidArgumentException $ignored)
                {
                }
            }
            switch ($code)
            {
                case '318A3' :
                {
                    $response = array_merge($response, $this->_pengukuran_beban_imbang_find_318A3_get($from, $to));
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

    private function _pengukuran_beban_imbang_find_318A3_get($from = null, $to = null)
    {
        /** @var array $response */
        $response = [];

        $this->load->model('model_rekap_pengukuran', 'mrp');

        $rekap = $this->mrp->find_beban_imbang("
            `id_ukur_gardu`    AS 'no'             ,
            `no_gardu`         AS 'no_gardu'       ,
            `nama_gardu_induk` AS 'gardu_induk'    ,
            `nama_penyulang`   AS 'gardu_penyulang',
            `lokasi`           AS 'lokasi'         ,
            `latitude`         AS 'latitude'       ,
            `longitude`        AS 'longitude'      ,
            `tgl_pengukuran`   AS 'date'           ,
            `wkt_pengukuran`   AS 'time'           ,
            `arus_R`           AS 'ir'             ,
            `arus_S`           AS 'is'             ,
            `arus_T`           AS 'it'             ,
            `ratarata`         AS 'mean'           ,
            `const_a`          AS 'const_a'        ,
            `const_b`          AS 'const_b'        ,
            `const_c`          AS 'const_c'        ,
            `prosen_imbang`    AS 'percent'        ,
            `status_beban`     AS 'status'         
            "
            , $from, $to)->result_array();
        if (empty($rekap))
        {
            $response['data']['rekap_pengukuran_beban_imbang'] = [];
        }
        else
        {
            $response['data']['rekap_pengukuran_beban_imbang'] = $rekap;
        }
        $response['data']['status'] = 1;

        return $response;
    }

    public function pengukuran_beban_imbang_download_get()
    {
        /** @var array $response */
        $response                   = [];
        $response['data']['status'] = 0;

        $this->lang->load("layout/rekap/pengukuran/beban/imbang/rekap_pengukuran_beban_imbang_common", $this->language);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            /** @var array $data
             * @var string $tables
             * @var string $identity_column
             */
            $data = [];

            $from = $this->getOrDefault('from', null);
            $to   = $this->getOrDefault('to', null);

            $this->load->model('model_rekap_pengukuran', 'mrp');

            $rekap = $this->mrp->find_beban_imbang("
            `id_ukur_gardu`    AS 'no'             ,
            `no_gardu`         AS 'no_gardu'       ,
            `nama_gardu_induk` AS 'gardu_induk'    ,
            `nama_penyulang`   AS 'gardu_penyulang',
            `lokasi`           AS 'lokasi'         ,
            `latitude`         AS 'latitude'       ,
            `longitude`        AS 'longitude'      ,
            `tgl_pengukuran`   AS 'date'           ,
            `wkt_pengukuran`   AS 'time'           ,
            `arus_R`           AS 'ir'             ,
            `arus_S`           AS 'is'             ,
            `arus_T`           AS 'it'             ,
            `ratarata`         AS 'mean'           ,
            `const_a`          AS 'const_a'        ,
            `const_b`          AS 'const_b'        ,
            `const_c`          AS 'const_c'        ,
            `prosen_imbang`    AS 'percent'        ,
            `status_beban`     AS 'status'         
            "
                , $from, $to)->result_array();
            if (!empty($rekap))
            {
                $excel = new PHPExcel();

                // Set document properties
                $excel->getProperties()->setCreator("Eka Yuliana")
                    ->setLastModifiedBy("PLN Bali Selatan")
                    ->setTitle("Rekapitulasi Beban Imbang")
                    ->setSubject("PLN")
                    ->setCategory("Rahasia");

                // Set lebar kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);

                // Mergecell, menyatukan beberapa kolom
                $excel->setActiveSheetIndex(0)->mergeCells('A1:R1');
                $excel->setActiveSheetIndex(0)->mergeCells('A2:R2');
                $excel->setActiveSheetIndex(0)->mergeCells('A3:R3');

                //Mengeset Style nya
                $titlestyle  = new PHPExcel_Style();
                $headerstyle = new PHPExcel_Style();
                $bodystyle   = new PHPExcel_Style();

                //setting title style
                $titlestyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ));

                //setting header style
                $headerstyle->applyFromArray(
                    array('font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000')),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('argb' => 'FFEEEEEE')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                        'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                //setting body style
                $bodystyle->applyFromArray(
                    array('fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('argb' => 'FFFFFFFF')),
                        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                        'borders' => array(
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
                            'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                        )
                    ));

                // mulai dari baris ke 4
                $row = 4;

                if (!is_null($from) && !is_null($to))
                {
                    $tglstart = Carbon::createFromFormat('Y-m-d', $from)->formatLocalized('%d %B %Y');
                    $tglend   = Carbon::createFromFormat('Y-m-d', $to)->formatLocalized('%d %B %Y');

                    $rentang = 'Berdasarkan Data Pengukuran Gardu pada Tanggal ' . $tglstart . ' s/d ' . $tglend;
                }
                else
                {
                    $rentang = 'Berdasarkan Data Pengukuran Gardu';
                }

                // Tulis judul tabel
                $excel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'PT. PLN (Persero) Area Bali Selatan')
                    ->setCellValue('A2', 'REKAPITULASI BEBAN IMBANG')
                    ->setCellValue('A3', $rentang)
                    ->setCellValue('A' . $row, 'No')
                    ->setCellValue('B' . $row, 'No. Gardu')
                    ->setCellValue('C' . $row, 'Gardu Induk')
                    ->setCellValue('D' . $row, 'Penyulang')
                    ->setCellValue('E' . $row, 'Lokasi')
                    ->setCellValue('F' . $row, 'Latitude')
                    ->setCellValue('G' . $row, 'Longitude')
                    ->setCellValue('H' . $row, 'Tgl Pengukuran')
                    ->setCellValue('I' . $row, 'Waktu Pengukuran')
                    ->setCellValue('J' . $row, 'Arus R')
                    ->setCellValue('K' . $row, 'Arus S')
                    ->setCellValue('L' . $row, 'Arus T')
                    ->setCellValue('M' . $row, 'Rata-Rata')
                    ->setCellValue('N' . $row, 'Const a')
                    ->setCellValue('O' . $row, 'Const b')
                    ->setCellValue('P' . $row, 'Const c')
                    ->setCellValue('Q' . $row, 'Prosen Imbang')
                    ->setCellValue('R' . $row, 'Status Beban');

                //Menggunakan TitleStylenya
                $excel->getActiveSheet()->setSharedStyle($titlestyle, "A1:R3");

                //Menggunakan HeaderStylenya
                $excel->getActiveSheet()->setSharedStyle($headerstyle, "A4:R4");

                $nomor = 1; // set nomor urut = 1;

                $row++; // pindah ke row bawahnya.

                // lakukan perulangan untuk menuliskan data siswa
                foreach ($rekap as $key => $content)
                {
                    $tgl = Carbon::createFromFormat('Y-m-d', $content['date'])->formatLocalized('%d %B %Y');
                    $wkt = Carbon::createFromFormat('H:i:s', $content['time'])->formatLocalized('%H:%M:%S');

                    $excel->setActiveSheetIndex(0)
                        ->setCellValueExplicit('A' . $row, $nomor, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('B' . $row, $content['no_gardu'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('C' . $row, $content['gardu_induk'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('D' . $row, $content['gardu_penyulang'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('E' . $row, $content['lokasi'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('F' . $row, $content['latitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('G' . $row, $content['longitude'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('H' . $row, $tgl, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('I' . $row, $wkt, PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('J' . $row, $content['ir'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('K' . $row, $content['is'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('L' . $row, $content['it'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('M' . $row, $content['mean'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('N' . $row, $content['const_a'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('O' . $row, $content['const_b'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('P' . $row, $content['const_c'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('Q' . $row, $content['percent'], PHPExcel_Cell_DataType::TYPE_STRING)
                        ->setCellValueExplicit('R' . $row, $content['status'], PHPExcel_Cell_DataType::TYPE_STRING);

                    $row++; // pindah ke row bawahnya ($row + 1)
                    $nomor++;
                }

                //Membuat garis di body tabel (isi data)
                $excel->getActiveSheet()->setSharedStyle($bodystyle, "A5:R$row");

                // Set sheet yang aktif adalah index pertama, jadi saat dibuka akan langsung fokus ke sheet pertama
                $excel->setActiveSheetIndex(0);

                // Mencetak File Excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                if (!is_null($from) && !is_null($to))
                {
                    $_filename = "rekap-bbngardu-imbang_$from-to-$to.xlsx";
                }
                else
                {
                    $_filename = "rekap-bbngardu-imbang.xlsx";
                }
                header("Content-Disposition: attachment;filename=$_filename");
                header('Cache-Control: max-age=0');

                $objWriter = new PHPExcel_Writer_Excel5($excel);
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
                $response['data']['download']['content']  = "data:application/vnd.ms-excel;base64," . base64_encode($xlsData);
                $response['data']['download']['filename'] = $_filename;
            }
            $response['data']['status'] = 1;
        }
        else
        {
            $response['data']['message']['message']['download']['info'] = [$this->lang->line('rekap_pengukuran_beban_imbang_common_download_forbidden')];
        }

        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }
}

?>

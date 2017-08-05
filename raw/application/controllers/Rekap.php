<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 04 August 2017, 7:41 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Rekap
 * @property CI_Loader load
 * @property CI_Lang lang
 * @property Ion_auth ion_auth
 * @property CI_Config config
 * @property CI_Session session
 * @property CI_Input input
 * @property Model_gardu_index mgidx
 */
class Rekap extends CI_Controller
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
     * @var string $language
     * @var string $country
     * @var string $lang_prefix
     * @var string $lang_layout
     * @var string $lang_prefix_path
     */
    private $language;
    private $country;
    private $lang_prefix;
    private $lang_layout;
    private $lang_prefix_path;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('cookie');
        $this->load->database();
        /** @noinspection PhpParamsInspection */
        $this->load->library(['ion_auth', 'session']);

        $this->language = empty($this->language = get_cookie('common_language')) ? $this->config->item('language') : $this->language;
        $this->country  = empty($this->country = get_cookie('common_country')) ? $this->config->item('country') : $this->country;
    }

    public function pengukuran($gardu = 'gardu')
    {
        $this->load->helper(['url', 'i18n']);
        $group = $this->session->userdata('group');
        $group = empty($group) ? 'admin' : $group;
        switch ($group)
        {
            case 'admin' :
            {
                switch ($gardu)
                {
                    case 'gardu' :
                    {
                        return $this->_pengukuran_gardu();
                    }
                }
            }
            break;
            case 'members':
            {
                //return $this->_pengukuran_member();
            }
            break;
            default :
            {
                show_404();
            }
        }
    }

    private function _pengukuran_gardu()
    {
        $this->lang_prefix      = 'rekap_pengukuran_gardu_admin';
        $this->lang_layout      = 'common_layout';
        $this->lang_prefix_path = 'rekap/pengukuran/gardu/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);
        $this->lang->load("layout/rekap/pengukuran/gardu/rekap_pengukuran_gardu_common", $this->language);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $this->load->helper('form');

            $this->lang->load('common/auth/common_auth_common', $this->language);
            $this->lang->load('common/profile/common_profile_common', $this->language);
            $this->lang->load('common/profile/edit/common_profile_edit_common', $this->language);
            $this->lang->load('common/sidebar/common_sidebar_common', $this->language);
            $this->lang->load('common/auth/common_auth_register_form', $this->language);
            $this->lang->load('common', $this->language);

            $string = [];
            $meta   = [];
            $data   = [];
            $view   = [];

            $_user                        = $this->ion_auth->user()->row_array();
            $data['profile']['username']  = $_user['username'];
            $data['profile']['email']     = $_user['email'];
            $data['profile']['group']     = 'Admin';
            $data['update']['redirector'] = site_url('/management/user');

            //Core Data
            $string['title']        = $this->lang->line('common_title');
            $string['page_title']   = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_page_title");
            $string['auth_logout']  = $this->lang->line('common_auth_common_logout');
            $string['profile_edit'] = $this->lang->line('common_profile_common_edit_button');

            //Sidebar
            $string['sidebar_home']                        = $this->lang->line('common_sidebar_common_sidebar_home');
            $string['sidebar_recapitulation']              = $this->lang->line('common_sidebar_common_sidebar_recapitulation');
            $string['sidebar_recapitulation_measurement']  = $this->lang->line('common_sidebar_common_sidebar_recapitulation_measurement');
            $string['sidebar_recapitulation_voltage_end']  = $this->lang->line('common_sidebar_common_sidebar_recapitulation_voltage_end');
            $string['sidebar_recapitulation_travo_load']   = $this->lang->line('common_sidebar_common_sidebar_recapitulation_travo_load');
            $string['sidebar_recapitulation_load_balance'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_load_balance');
            $string['sidebar_info_gardu']                  = $this->lang->line('common_sidebar_common_sidebar_info_gardu');
            $string['sidebar_info_gardu_hq']               = $this->lang->line('common_sidebar_common_sidebar_info_gardu_hq');
            $string['sidebar_info_gardu_feeder']           = $this->lang->line('common_sidebar_common_sidebar_info_gardu_feeder');
            $string['sidebar_info_gardu_data']             = $this->lang->line('common_sidebar_common_sidebar_info_gardu_data');
            $string['sidebar_info_user_management']        = $this->lang->line('common_sidebar_common_sidebar_info_user_management');

            //Profile
            $string['client_register']                  = $this->lang->line('common_auth_common_register');
            $string['client_form_username_label']       = $this->lang->line('common_auth_register_form_username_label');
            $string['client_form_email_label']          = $this->lang->line('common_auth_register_form_email_label');
            $string['client_form_role_label']           = $this->lang->line('common_auth_register_form_role_label');
            $string['client_form_username_placeholder'] = $this->lang->line("common_profile_edit_common_client_username_placeholder");
            $string['client_form_email_placeholder']    = $this->lang->line("common_profile_edit_common_client_email_placeholder");
            $string['inline_client_form_id_id']         = 'id';
            $string['inline_client_form_username_id']   = 'username';
            $string['inline_client_form_email_id']      = 'email';
            $string['inline_client_form_role_id']       = 'role';

            //Item Creation Form


            //Table
            $string['tabel']['header']['no_gardu']        = 'No. Gardu';
            $string['tabel']['header']['gardu_induk']     = 'Gardu Induk';
            $string['tabel']['header']['gardu_penyulang'] = 'Penyulang';
            $string['tabel']['header']['lokasi']          = 'Lokasi';
            $string['tabel']['header']['latitude']        = 'Latitude';
            $string['tabel']['header']['longitude']       = 'Longitude';
            $string['tabel']['header']['petugas_1']       = 'Nama Petugas 1';
            $string['tabel']['header']['petugas_2']       = 'Nama Petugas 2';
            $string['tabel']['header']['no_kontrak']      = 'No. Kontrak';
            $string['tabel']['header']['date']            = 'Tanggal';
            $string['tabel']['header']['time']            = 'Waktu';
            $string['tabel']['header']['umum_1']          = 'Jusuan 1';
            $string['tabel']['header']['umum_2']          = 'Jusuan 2';
            $string['tabel']['header']['umum_3']          = 'Jusuan 3';
            $string['tabel']['header']['umum_4']          = 'Jusuan 4';
            $string['tabel']['header']['khusus_1']        = 'Jusuan Khusus 1';
            $string['tabel']['header']['khusus_2']        = 'Jusuan Khusus 2';
            $string['tabel']['header']['ir']              = 'Arus R';
            $string['tabel']['header']['is']              = 'Arus S';
            $string['tabel']['header']['it']              = 'Arus T';
            $string['tabel']['header']['in']              = 'Arus N';
            $string['tabel']['header']['vrn']             = 'Tegangan RN';
            $string['tabel']['header']['vsn']             = 'Tegangan SN';
            $string['tabel']['header']['vtn']             = 'Tegangan TN';
            $string['tabel']['header']['vrs']             = 'Tegangan RS';
            $string['tabel']['header']['vrt']             = 'Tegangan RT';
            $string['tabel']['header']['vst']             = 'Tegangan ST';
            $string['tabel']['header']['id_u1']           = 'ID Jurusan';
            $string['tabel']['header']['ir_u1']           = 'Arus R';
            $string['tabel']['header']['is_u1']           = 'Arus S';
            $string['tabel']['header']['it_u1']           = 'Arus T';
            $string['tabel']['header']['in_u1']           = 'Arus N';
            $string['tabel']['header']['vrn_u1']          = 'Tegangan RN';
            $string['tabel']['header']['vsn_u1']          = 'Tegangan SN';
            $string['tabel']['header']['vtn_u1']          = 'Tegangan TN';
            $string['tabel']['header']['vrs_u1']          = 'Tegangan RS';
            $string['tabel']['header']['vrt_u1']          = 'Tegangan RT';
            $string['tabel']['header']['vst_u1']          = 'Tegangan ST';
            $string['tabel']['header']['id_u2']           = 'ID Jurusan';
            $string['tabel']['header']['ir_u2']           = 'Arus R';
            $string['tabel']['header']['is_u2']           = 'Arus S';
            $string['tabel']['header']['it_u2']           = 'Arus T';
            $string['tabel']['header']['in_u2']           = 'Arus N';
            $string['tabel']['header']['vrn_u2']          = 'Tegangan RN';
            $string['tabel']['header']['vsn_u2']          = 'Tegangan SN';
            $string['tabel']['header']['vtn_u2']          = 'Tegangan TN';
            $string['tabel']['header']['vrs_u2']          = 'Tegangan RS';
            $string['tabel']['header']['vrt_u2']          = 'Tegangan RT';
            $string['tabel']['header']['vst_u2']          = 'Tegangan ST';
            $string['tabel']['header']['id_u3']           = 'ID Jurusan';
            $string['tabel']['header']['ir_u3']           = 'Arus R';
            $string['tabel']['header']['is_u3']           = 'Arus S';
            $string['tabel']['header']['it_u3']           = 'Arus T';
            $string['tabel']['header']['in_u3']           = 'Arus N';
            $string['tabel']['header']['vrn_u3']          = 'Tegangan RN';
            $string['tabel']['header']['vsn_u3']          = 'Tegangan SN';
            $string['tabel']['header']['vtn_u3']          = 'Tegangan TN';
            $string['tabel']['header']['vrs_u3']          = 'Tegangan RS';
            $string['tabel']['header']['vrt_u3']          = 'Tegangan RT';
            $string['tabel']['header']['vst_u3']          = 'Tegangan ST';
            $string['tabel']['header']['id_u4']           = 'ID Jurusan';
            $string['tabel']['header']['ir_u4']           = 'Arus R';
            $string['tabel']['header']['is_u4']           = 'Arus S';
            $string['tabel']['header']['it_u4']           = 'Arus T';
            $string['tabel']['header']['in_u4']           = 'Arus N';
            $string['tabel']['header']['vrn_u4']          = 'Tegangan RN';
            $string['tabel']['header']['vsn_u4']          = 'Tegangan SN';
            $string['tabel']['header']['vtn_u4']          = 'Tegangan TN';
            $string['tabel']['header']['vrs_u4']          = 'Tegangan RS';
            $string['tabel']['header']['vrt_u4']          = 'Tegangan RT';
            $string['tabel']['header']['vst_u4']          = 'Tegangan ST';
            $string['tabel']['header']['id_k1']           = 'ID Jurusan';
            $string['tabel']['header']['ir_k1']           = 'Arus R';
            $string['tabel']['header']['is_k1']           = 'Arus S';
            $string['tabel']['header']['it_k1']           = 'Arus T';
            $string['tabel']['header']['in_k1']           = 'Arus N';
            $string['tabel']['header']['vrn_k1']          = 'Tegangan RN';
            $string['tabel']['header']['vsn_k1']          = 'Tegangan SN';
            $string['tabel']['header']['vtn_k1']          = 'Tegangan TN';
            $string['tabel']['header']['vrs_k1']          = 'Tegangan RS';
            $string['tabel']['header']['vrt_k1']          = 'Tegangan RT';
            $string['tabel']['header']['vst_k1']          = 'Tegangan ST';
            $string['tabel']['header']['id_k2']           = 'ID Jurusan';
            $string['tabel']['header']['ir_k2']           = 'Arus R';
            $string['tabel']['header']['is_k2']           = 'Arus S';
            $string['tabel']['header']['it_k2']           = 'Arus T';
            $string['tabel']['header']['in_k2']           = 'Arus N';
            $string['tabel']['header']['vrn_k2']          = 'Tegangan RN';
            $string['tabel']['header']['vsn_k2']          = 'Tegangan SN';
            $string['tabel']['header']['vtn_k2']          = 'Tegangan TN';
            $string['tabel']['header']['vrs_k2']          = 'Tegangan RS';
            $string['tabel']['header']['vrt_k2']          = 'Tegangan RT';
            $string['tabel']['header']['vst_k2']          = 'Tegangan ST';

            $string['button']['download'] = 'Unduh';

            $meta['retriever']      = site_url('/api/rekap/pengukuran/gardu/find?code=82AF2');
            $meta['download']       = site_url('/api/rekap/pengukuran/gardu/download?from=%s&to=%s');
            $meta['datatable_lang'] = base_url($this->lang->line('common_datatable_lang'));

            $data['meta']['i18n']['country']  = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata']     = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

            $_properties = compact('meta', 'string', 'data');

            $view['sidebar']      = $this->load->view("common/common_menus_{$this->lang_layout}", $_properties, true);
            $view['edit_profile'] = $this->load->view("common/profile/common_profile_edit_{$this->lang_layout}", $_properties, true);

            $_properties['view'] = $view;
            $this->load->view("{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $_properties);
        }
        else
        {
            $this->session->set_flashdata([
                'flashdata' => [
                    'message' => [
                        $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_forbidden_access"),
                        $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_forbidden_access_auth_redirection")
                    ]
                    , 'redirector' => site_url("/rekap/pengukuran/gardu")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }
}

?>

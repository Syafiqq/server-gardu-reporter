<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 18 July 2017, 8:11 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Gardu
 * @property CI_Loader load
 * @property CI_Lang lang
 * @property Ion_auth ion_auth
 * @property CI_Config config
 * @property CI_Session session
 * @property CI_Input input
 * @property Model_gardu_index mgidx
 */
class Gardu extends CI_Controller
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
    private $group;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('cookie');
        $this->load->database();
        /** @noinspection PhpParamsInspection */
        $this->load->library(['ion_auth', 'session']);
        $this->group = $this->session->userdata('group');

        $this->language = empty($this->language = get_cookie('common_language')) ? $this->config->item('language') : $this->language;
        $this->country  = empty($this->country = get_cookie('common_country')) ? $this->config->item('country') : $this->country;
    }

    public function index()
    {
        $this->load->helper(['url', 'i18n']);
        switch ($this->group)
        {
            case 'admin' :
            {
                return $this->_index_admin();
            }
            break;
            case 'members':
            {
                return $this->_index_member();
            }
            break;
            default :
            {
                show_404();
            }
        }
    }

    private function _index_admin()
    {
        $this->lang_prefix      = 'gardu_index_admin';
        $this->lang_layout      = 'common_layout';
        $this->lang_prefix_path = 'gardu/index/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);
        $this->lang->load("layout/gardu/index/gardu_index_common", $this->language);

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
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
            $string['item_creation_title']    = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_title");
            $string['item_creation_register'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_button");
            $string['item_creation_reset']    = $this->lang->line('common_auth_common_reset');

            $string['item_creation_form_induk_id_label']     = $this->lang->line("gardu_index_common_form_induk_id_label");
            $string['item_creation_form_penyulang_id_label'] = $this->lang->line("gardu_index_common_form_penyulang_id_label");
            $string['item_creation_form_jenis_label']        = $this->lang->line("gardu_index_common_form_jenis_label");
            $string['item_creation_form_no_label']           = $this->lang->line("gardu_index_common_form_no_label");
            $string['item_creation_form_lokasi_label']       = $this->lang->line("gardu_index_common_form_lokasi_label");
            $string['item_creation_form_merk_label']         = $this->lang->line("gardu_index_common_form_merk_label");
            $string['item_creation_form_serial_label']       = $this->lang->line("gardu_index_common_form_serial_label");
            $string['item_creation_form_daya_label']         = $this->lang->line("gardu_index_common_form_daya_label");
            $string['item_creation_form_fasa_label']         = $this->lang->line("gardu_index_common_form_fasa_label");
            $string['item_creation_form_tap_label']          = $this->lang->line("gardu_index_common_form_tap_label");
            $string['item_creation_form_jurusan_label']      = $this->lang->line("gardu_index_common_form_jurusan_label");
            $string['item_creation_form_lat_label']          = $this->lang->line("gardu_index_common_form_lat_label");
            $string['item_creation_form_long_label']         = $this->lang->line("gardu_index_common_form_long_label");

            $string['item_creation_form_induk_id_placeholder']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_induk_id_placeholder");
            $string['item_creation_form_penyulang_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_penyulang_id_placeholder");
            $string['item_creation_form_jenis_placeholder']        = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_jenis_placeholder");
            $string['item_creation_form_no_placeholder']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_no_placeholder");
            $string['item_creation_form_lokasi_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_lokasi_placeholder");
            $string['item_creation_form_merk_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_merk_placeholder");
            $string['item_creation_form_serial_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_serial_placeholder");
            $string['item_creation_form_daya_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_daya_placeholder");
            $string['item_creation_form_fasa_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_fasa_placeholder");
            $string['item_creation_form_tap_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_tap_placeholder");
            $string['item_creation_form_jurusan_placeholder']      = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_jurusan_placeholder");
            $string['item_creation_form_lat_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_lat_placeholder");
            $string['item_creation_form_long_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_long_placeholder");

            $string['item_creation_form_id_induk_id']     = 'induk_id';
            $string['item_creation_form_id_penyulang_id'] = 'penyulang_id';
            $string['item_creation_form_id_jenis']        = 'jenis';
            $string['item_creation_form_id_no']           = 'no';
            $string['item_creation_form_id_lokasi']       = 'lokasi';
            $string['item_creation_form_id_merk']         = 'merk';
            $string['item_creation_form_id_serial']       = 'serial';
            $string['item_creation_form_id_daya']         = 'daya';
            $string['item_creation_form_id_fasa']         = 'fasa';
            $string['item_creation_form_id_tap']          = 'tap';
            $string['item_creation_form_id_jurusan']      = 'jurusan';
            $string['item_creation_form_id_lat']          = 'lat';
            $string['item_creation_form_id_long']         = 'long';

            $string['item_manipulation_title']  = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_title");
            $string['item_manipulation_update'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_button");
            $string['item_manipulation_detail'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_detail");
            $string['item_manipulation_reset']  = $string['item_creation_reset'];


            $string['item_manipulation_form_induk_id_label']     = $this->lang->line("gardu_index_common_form_induk_id_label");
            $string['item_manipulation_form_penyulang_id_label'] = $this->lang->line("gardu_index_common_form_penyulang_id_label");
            $string['item_manipulation_form_jenis_label']        = $this->lang->line("gardu_index_common_form_jenis_label");
            $string['item_manipulation_form_no_label']           = $this->lang->line("gardu_index_common_form_no_label");
            $string['item_manipulation_form_lokasi_label']       = $this->lang->line("gardu_index_common_form_lokasi_label");
            $string['item_manipulation_form_merk_label']         = $this->lang->line("gardu_index_common_form_merk_label");
            $string['item_manipulation_form_serial_label']       = $this->lang->line("gardu_index_common_form_serial_label");
            $string['item_manipulation_form_daya_label']         = $this->lang->line("gardu_index_common_form_daya_label");
            $string['item_manipulation_form_fasa_label']         = $this->lang->line("gardu_index_common_form_fasa_label");
            $string['item_manipulation_form_tap_label']          = $this->lang->line("gardu_index_common_form_tap_label");
            $string['item_manipulation_form_jurusan_label']      = $this->lang->line("gardu_index_common_form_jurusan_label");
            $string['item_manipulation_form_lat_label']          = $this->lang->line("gardu_index_common_form_lat_label");
            $string['item_manipulation_form_long_label']         = $this->lang->line("gardu_index_common_form_long_label");

            $string['item_manipulation_form_induk_id_placeholder']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_induk_id_placeholder");
            $string['item_manipulation_form_penyulang_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_penyulang_id_placeholder");
            $string['item_manipulation_form_jenis_placeholder']        = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_jenis_placeholder");
            $string['item_manipulation_form_no_placeholder']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_no_placeholder");
            $string['item_manipulation_form_lokasi_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_lokasi_placeholder");
            $string['item_manipulation_form_merk_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_merk_placeholder");
            $string['item_manipulation_form_serial_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_serial_placeholder");
            $string['item_manipulation_form_daya_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_daya_placeholder");
            $string['item_manipulation_form_fasa_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_fasa_placeholder");
            $string['item_manipulation_form_tap_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_tap_placeholder");
            $string['item_manipulation_form_jurusan_placeholder']      = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_jurusan_placeholder");
            $string['item_manipulation_form_lat_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_lat_placeholder");
            $string['item_manipulation_form_long_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_long_placeholder");

            $string['item_manipulation_form_id_induk_id']     = 'induk_id';
            $string['item_manipulation_form_id_penyulang_id'] = 'penyulang_id';
            $string['item_manipulation_form_id_jenis']        = 'jenis';
            $string['item_manipulation_form_id_no']           = 'no';
            $string['item_manipulation_form_id_lokasi']       = 'lokasi';
            $string['item_manipulation_form_id_merk']         = 'merk';
            $string['item_manipulation_form_id_serial']       = 'serial';
            $string['item_manipulation_form_id_daya']         = 'daya';
            $string['item_manipulation_form_id_fasa']         = 'fasa';
            $string['item_manipulation_form_id_tap']          = 'tap';
            $string['item_manipulation_form_id_jurusan']      = 'jurusan';
            $string['item_manipulation_form_id_lat']          = 'lat';
            $string['item_manipulation_form_id_long']         = 'long';

            //Table
            $string['add_new_item'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_add_new_item");

            $string['table_header_induk_id']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_induk_id");
            $string['table_header_penyulang_id'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_penyulang_id");
            $string['table_header_no']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_no");
            $string['table_header_location']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_location");
            $string['table_header_option']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_option");

            $meta['retriever']           = site_url('/api/gardu/index/find?code=FE37A');
            $meta['induk_retriever']     = site_url('/api/gardu/induk/find?code=C41AF');
            $meta['penyulang_retriever'] = site_url('/api/gardu/penyulang/find?code=B28FE');
            $meta['deleter']             = site_url('/api/gardu/index/delete');
            $meta['editer']              = site_url('/api/gardu/index/update');
            $meta['detail']              = site_url('/gardu/detail?gardu=%s');
            $meta['datatable_lang']      = base_url($this->lang->line('common_datatable_lang'));

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
                    , 'redirector' => site_url("/gardu")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _index_member()
    {
        $this->lang_prefix      = 'gardu_index_member';
        $this->lang_layout      = 'common_layout';
        $this->lang_prefix_path = 'gardu/index/member';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);
        $this->lang->load("layout/gardu/index/gardu_index_common", $this->language);

        if ($this->ion_auth->logged_in() && ($this->group === 'members'))
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
            $string['item_creation_title']    = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_title");
            $string['item_creation_register'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_button");
            $string['item_creation_reset']    = $this->lang->line('common_auth_common_reset');

            $string['item_creation_form_induk_id_label']     = $this->lang->line("gardu_index_common_form_induk_id_label");
            $string['item_creation_form_penyulang_id_label'] = $this->lang->line("gardu_index_common_form_penyulang_id_label");
            $string['item_creation_form_jenis_label']        = $this->lang->line("gardu_index_common_form_jenis_label");
            $string['item_creation_form_no_label']           = $this->lang->line("gardu_index_common_form_no_label");
            $string['item_creation_form_lokasi_label']       = $this->lang->line("gardu_index_common_form_lokasi_label");
            $string['item_creation_form_merk_label']         = $this->lang->line("gardu_index_common_form_merk_label");
            $string['item_creation_form_serial_label']       = $this->lang->line("gardu_index_common_form_serial_label");
            $string['item_creation_form_daya_label']         = $this->lang->line("gardu_index_common_form_daya_label");
            $string['item_creation_form_fasa_label']         = $this->lang->line("gardu_index_common_form_fasa_label");
            $string['item_creation_form_tap_label']          = $this->lang->line("gardu_index_common_form_tap_label");
            $string['item_creation_form_jurusan_label']      = $this->lang->line("gardu_index_common_form_jurusan_label");
            $string['item_creation_form_lat_label']          = $this->lang->line("gardu_index_common_form_lat_label");
            $string['item_creation_form_long_label']         = $this->lang->line("gardu_index_common_form_long_label");

            $string['item_creation_form_induk_id_placeholder']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_induk_id_placeholder");
            $string['item_creation_form_penyulang_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_penyulang_id_placeholder");
            $string['item_creation_form_jenis_placeholder']        = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_jenis_placeholder");
            $string['item_creation_form_no_placeholder']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_no_placeholder");
            $string['item_creation_form_lokasi_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_lokasi_placeholder");
            $string['item_creation_form_merk_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_merk_placeholder");
            $string['item_creation_form_serial_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_serial_placeholder");
            $string['item_creation_form_daya_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_daya_placeholder");
            $string['item_creation_form_fasa_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_fasa_placeholder");
            $string['item_creation_form_tap_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_tap_placeholder");
            $string['item_creation_form_jurusan_placeholder']      = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_jurusan_placeholder");
            $string['item_creation_form_lat_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_lat_placeholder");
            $string['item_creation_form_long_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_long_placeholder");

            $string['item_creation_form_id_induk_id']     = 'induk_id';
            $string['item_creation_form_id_penyulang_id'] = 'penyulang_id';
            $string['item_creation_form_id_jenis']        = 'jenis';
            $string['item_creation_form_id_no']           = 'no';
            $string['item_creation_form_id_lokasi']       = 'lokasi';
            $string['item_creation_form_id_merk']         = 'merk';
            $string['item_creation_form_id_serial']       = 'serial';
            $string['item_creation_form_id_daya']         = 'daya';
            $string['item_creation_form_id_fasa']         = 'fasa';
            $string['item_creation_form_id_tap']          = 'tap';
            $string['item_creation_form_id_jurusan']      = 'jurusan';
            $string['item_creation_form_id_lat']          = 'lat';
            $string['item_creation_form_id_long']         = 'long';

            $string['item_manipulation_title']  = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_title");
            $string['item_manipulation_update'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_button");
            $string['item_manipulation_detail'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_detail");
            $string['item_manipulation_reset']  = $string['item_creation_reset'];


            $string['item_manipulation_form_induk_id_label']     = $this->lang->line("gardu_index_common_form_induk_id_label");
            $string['item_manipulation_form_penyulang_id_label'] = $this->lang->line("gardu_index_common_form_penyulang_id_label");
            $string['item_manipulation_form_jenis_label']        = $this->lang->line("gardu_index_common_form_jenis_label");
            $string['item_manipulation_form_no_label']           = $this->lang->line("gardu_index_common_form_no_label");
            $string['item_manipulation_form_lokasi_label']       = $this->lang->line("gardu_index_common_form_lokasi_label");
            $string['item_manipulation_form_merk_label']         = $this->lang->line("gardu_index_common_form_merk_label");
            $string['item_manipulation_form_serial_label']       = $this->lang->line("gardu_index_common_form_serial_label");
            $string['item_manipulation_form_daya_label']         = $this->lang->line("gardu_index_common_form_daya_label");
            $string['item_manipulation_form_fasa_label']         = $this->lang->line("gardu_index_common_form_fasa_label");
            $string['item_manipulation_form_tap_label']          = $this->lang->line("gardu_index_common_form_tap_label");
            $string['item_manipulation_form_jurusan_label']      = $this->lang->line("gardu_index_common_form_jurusan_label");
            $string['item_manipulation_form_lat_label']          = $this->lang->line("gardu_index_common_form_lat_label");
            $string['item_manipulation_form_long_label']         = $this->lang->line("gardu_index_common_form_long_label");

            $string['item_manipulation_form_induk_id_placeholder']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_induk_id_placeholder");
            $string['item_manipulation_form_penyulang_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_penyulang_id_placeholder");
            $string['item_manipulation_form_jenis_placeholder']        = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_jenis_placeholder");
            $string['item_manipulation_form_no_placeholder']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_no_placeholder");
            $string['item_manipulation_form_lokasi_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_lokasi_placeholder");
            $string['item_manipulation_form_merk_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_merk_placeholder");
            $string['item_manipulation_form_serial_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_serial_placeholder");
            $string['item_manipulation_form_daya_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_daya_placeholder");
            $string['item_manipulation_form_fasa_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_fasa_placeholder");
            $string['item_manipulation_form_tap_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_tap_placeholder");
            $string['item_manipulation_form_jurusan_placeholder']      = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_jurusan_placeholder");
            $string['item_manipulation_form_lat_placeholder']          = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_lat_placeholder");
            $string['item_manipulation_form_long_placeholder']         = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_long_placeholder");

            $string['item_manipulation_form_id_induk_id']     = 'induk_id';
            $string['item_manipulation_form_id_penyulang_id'] = 'penyulang_id';
            $string['item_manipulation_form_id_jenis']        = 'jenis';
            $string['item_manipulation_form_id_no']           = 'no';
            $string['item_manipulation_form_id_lokasi']       = 'lokasi';
            $string['item_manipulation_form_id_merk']         = 'merk';
            $string['item_manipulation_form_id_serial']       = 'serial';
            $string['item_manipulation_form_id_daya']         = 'daya';
            $string['item_manipulation_form_id_fasa']         = 'fasa';
            $string['item_manipulation_form_id_tap']          = 'tap';
            $string['item_manipulation_form_id_jurusan']      = 'jurusan';
            $string['item_manipulation_form_id_lat']          = 'lat';
            $string['item_manipulation_form_id_long']         = 'long';

            //Table
            $string['add_new_item'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_add_new_item");

            $string['table_header_induk_id']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_induk_id");
            $string['table_header_penyulang_id'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_penyulang_id");
            $string['table_header_no']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_no");
            $string['table_header_location']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_location");
            $string['table_header_option']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_option");

            $meta['retriever']           = site_url('/api/gardu/index/find?code=FE37A');
            $meta['induk_retriever']     = site_url('/api/gardu/induk/find?code=C41AF');
            $meta['penyulang_retriever'] = site_url('/api/gardu/penyulang/find?code=B28FE');
            $meta['editer']              = site_url('/api/gardu/index/update');
            $meta['detail']              = site_url('/gardu/detail?gardu=%s');
            $meta['datatable_lang']      = base_url($this->lang->line('common_datatable_lang'));

            $data['meta']['i18n']['country']  = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata']     = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

            $_properties = compact('meta', 'string', 'data');

            $view['sidebar']      = $this->load->view("common/common_menus_member_{$this->lang_layout}", $_properties, true);
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
                    , 'redirector' => site_url("/gardu")
                ]
            ]);
            redirect('/auth/login/members');
        }
    }

    public function penyulang()
    {
        $this->load->helper(['url', 'i18n']);
        switch ($this->group)
        {
            case 'admin' :
            {
                return $this->_penyulang_admin();
            }
            break;
            case 'members':
            {
                return $this->_penyulang_memeber();
            }
            break;
            default :
            {
                show_404();
            }
        }
    }

    private function _penyulang_admin()
    {
        $this->lang_prefix      = 'gardu_penyulang_admin';
        $this->lang_layout      = 'common_layout';
        $this->lang_prefix_path = 'gardu/penyulang/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
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
            $string['item_creation_title']                     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_title");
            $string['item_creation_register']                  = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_button");
            $string['item_creation_reset']                     = $this->lang->line('common_auth_common_reset');
            $string['item_creation_form_id_label']             = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_label");
            $string['item_creation_form_name_label']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_label");
            $string['item_creation_form_id_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_placeholder");
            $string['item_creation_form_name_placeholder']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_placeholder");
            $string['item_creation_form_id_id']                = 'id';
            $string['item_creation_form_name_id']              = 'name';
            $string['item_manipulation_title']                 = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_title");
            $string['item_manipulation_update']                = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_button");
            $string['item_manipulation_reset']                 = $string['item_creation_reset'];
            $string['item_manipulation_form_id_label']         = $string['item_creation_form_id_label'];
            $string['item_manipulation_form_name_label']       = $string['item_creation_form_name_label'];
            $string['item_manipulation_form_name_placeholder'] = $string['item_creation_form_name_placeholder'];
            $string['item_manipulation_form_id_id']            = $string['item_creation_form_id_id'];
            $string['item_manipulation_form_name_id']          = $string['item_creation_form_name_id'];

            //Table
            $string['add_new_item']        = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_add_new_item");
            $string['table_header_code']   = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_code");
            $string['table_header_name']   = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_name");
            $string['table_header_option'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_option");

            $meta['retriever']      = site_url('/api/gardu/penyulang/find?code=B28FE');
            $meta['deleter']        = site_url('/api/gardu/penyulang/delete');
            $meta['editer']         = site_url('/api/gardu/penyulang/update');
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
                    , 'redirector' => site_url("/gardu/penyulangf")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _penyulang_memeber()
    {

    }

    public function induk()
    {
        $this->load->helper(['url', 'i18n']);
        switch ($this->group)
        {
            case 'admin' :
            {
                return $this->_induk_admin();
            }
            break;
            case 'members':
            {
                return $this->_induk_member();
            }
            break;
            default :
            {
                show_404();
            }
        }
    }

    private function _induk_admin()
    {
        $this->lang_prefix      = 'gardu_induk_admin';
        $this->lang_layout      = 'common_layout';
        $this->lang_prefix_path = 'gardu/induk/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
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
            $string['item_creation_title']                     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_title");
            $string['item_creation_register']                  = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_button");
            $string['item_creation_reset']                     = $this->lang->line('common_auth_common_reset');
            $string['item_creation_form_id_label']             = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_label");
            $string['item_creation_form_name_label']           = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_label");
            $string['item_creation_form_id_placeholder']       = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_placeholder");
            $string['item_creation_form_name_placeholder']     = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_placeholder");
            $string['item_creation_form_id_id']                = 'id';
            $string['item_creation_form_name_id']              = 'name';
            $string['item_manipulation_title']                 = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_title");
            $string['item_manipulation_update']                = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_button");
            $string['item_manipulation_reset']                 = $string['item_creation_reset'];
            $string['item_manipulation_form_id_label']         = $string['item_creation_form_id_label'];
            $string['item_manipulation_form_name_label']       = $string['item_creation_form_name_label'];
            $string['item_manipulation_form_name_placeholder'] = $string['item_creation_form_name_placeholder'];
            $string['item_manipulation_form_id_id']            = $string['item_creation_form_id_id'];
            $string['item_manipulation_form_name_id']          = $string['item_creation_form_name_id'];

            //Table
            $string['add_new_item']        = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_add_new_item");
            $string['table_header_code']   = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_code");
            $string['table_header_name']   = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_name");
            $string['table_header_option'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_option");

            $meta['retriever']      = site_url('/api/gardu/induk/find?code=C41AF');
            $meta['deleter']        = site_url('/api/gardu/induk/delete');
            $meta['editer']         = site_url('/api/gardu/induk/update');
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
                    , 'redirector' => site_url("/gardu/induk")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _induk_member()
    {
    }

    public function detail()
    {
        $this->load->helper(['url', 'i18n']);
        switch ($this->group)
        {
            case 'admin' :
            {
                return $this->_detail_admin();
            }
            break;
            case 'members':
            {
                return $this->_detail_member();
            }
            break;
            default :
            {
                show_404();
            }
        }
    }

    private function _detail_admin()
    {
        $this->lang_prefix      = 'gardu_detail_admin';
        $this->lang_layout      = 'common_layout';
        $this->lang_prefix_path = 'gardu/detail/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);
        $this->lang->load("layout/gardu/index/gardu_index_common", $this->language);

        $gardu = $this->input->get('gardu');
        $this->load->model('model_gardu_index', 'mgidx');
        if (empty($gardu))
        {
            $flashdata = [$this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_no_gardu_filled")];
            $this->session->set_flashdata(['flashdata' => ['message' => $flashdata]]);
            redirect('/gardu');

        }
        else if (!$this->mgidx->id_check($gardu))
        {
            $flashdata = [$this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_no_gardu_found")];
            $this->session->set_flashdata(['flashdata' => ['message' => $flashdata]]);
            redirect('/gardu');

            return;
        }
        else if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
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

            $string['item']['label']['induk_id']     = $this->lang->line("gardu_index_common_form_induk_id_label");
            $string['item']['label']['penyulang_id'] = $this->lang->line("gardu_index_common_form_penyulang_id_label");
            $string['item']['label']['jenis']        = $this->lang->line("gardu_index_common_form_jenis_label");
            $string['item']['label']['no']           = $this->lang->line("gardu_index_common_form_no_label");
            $string['item']['label']['lokasi']       = $this->lang->line("gardu_index_common_form_lokasi_label");
            $string['item']['label']['merk']         = $this->lang->line("gardu_index_common_form_merk_label");
            $string['item']['label']['serial']       = $this->lang->line("gardu_index_common_form_serial_label");
            $string['item']['label']['daya']         = $this->lang->line("gardu_index_common_form_daya_label");
            $string['item']['label']['fasa']         = $this->lang->line("gardu_index_common_form_fasa_label");
            $string['item']['label']['tap']          = $this->lang->line("gardu_index_common_form_tap_label");
            $string['item']['label']['jurusan']      = $this->lang->line("gardu_index_common_form_jurusan_label");
            $string['item']['label']['lat']          = $this->lang->line("gardu_index_common_form_lat_label");
            $string['item']['label']['long']         = $this->lang->line("gardu_index_common_form_long_label");

            $string['item']['id']['induk_id']     = 'induk_id';
            $string['item']['id']['penyulang_id'] = 'penyulang_id';
            $string['item']['id']['jenis']        = 'jenis';
            $string['item']['id']['no']           = 'no';
            $string['item']['id']['lokasi']       = 'lokasi';
            $string['item']['id']['merk']         = 'merk';
            $string['item']['id']['serial']       = 'serial';
            $string['item']['id']['daya']         = 'daya';
            $string['item']['id']['fasa']         = 'fasa';
            $string['item']['id']['tap']          = 'tap';
            $string['item']['id']['jurusan']      = 'jurusan';
            $string['item']['id']['lat']          = 'lat';
            $string['item']['id']['long']         = 'long';

            $string['map']['title']                = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_map_title");
            $string['map']['button']['show_route'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_map_button_show_route");

            $meta['retriever'] = site_url("/api/gardu/index/detail?gardu={$gardu}");

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
                    , 'redirector' => site_url("/{$this->lang_prefix_path}?gardu={$gardu}")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _detail_member()
    {

    }

    public function pengukuran($gardu = 'index')
    {
        $this->load->helper(['url', 'i18n']);
        switch ($this->group)
        {
            case 'admin' :
            {
                switch ($gardu)
                {
                    case 'index' :
                    {
                        return $this->_pengukuran_index_admin();
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

    private function _pengukuran_index_admin()
    {
        $this->lang_prefix      = 'gardu_pengukuran_index_admin';
        $this->lang_layout      = 'common_layout';
        $this->lang_prefix_path = 'gardu/pengukuran/index/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);
        $this->lang->load("layout/gardu/pengukuran/index/gardu_pengukuran_index_common", $this->language);

        if ($this->ion_auth->logged_in() && ($this->group === 'admin'))
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

            //Form
            $string['form']['jurusan']['umum']['title']                 = 'Jurusan Umum';
            $string['form']['jurusan']['umum']['content'][0]['title']   = 'Jurusan 1';
            $string['form']['jurusan']['umum']['content'][1]['title']   = 'Jurusan 2';
            $string['form']['jurusan']['umum']['content'][2]['title']   = 'Jurusan 3';
            $string['form']['jurusan']['umum']['content'][3]['title']   = 'Jurusan 4';
            $string['form']['jurusan']['khusus']['title']               = 'Jurusan Khusus';
            $string['form']['jurusan']['khusus']['content'][0]['title'] = 'Jurusan 1';
            $string['form']['jurusan']['khusus']['content'][1]['title'] = 'Jurusan 2';

            $string['form']['no_gardu']['label']                                          = 'No Gardu';
            $string['form']['create_gardu_index']['label']                                = 'Masukkan Data Gardu';
            $string['form']['date']['label']                                              = 'Tanggal';
            $string['form']['time']['label']                                              = 'Waktu';
            $string['form']['worker']['worker1']['label']                                 = 'Nama Petugas 1';
            $string['form']['worker']['worker2']['label']                                 = 'Nama Petugas 2';
            $string['form']['worker']['contract']['label']                                = 'No. Kontrak';
            $string['form']['arus'][0][0]['label']                                        = 'Arus R';
            $string['form']['arus'][0][1]['label']                                        = 'Arus S';
            $string['form']['arus'][1][0]['label']                                        = 'Arus T';
            $string['form']['arus'][1][1]['label']                                        = 'Arus N';
            $string['form']['tegangan'][0][0]['label']                                    = 'Tegangan RN';
            $string['form']['tegangan'][0][1]['label']                                    = 'Tegangan SN';
            $string['form']['tegangan'][0][2]['label']                                    = 'Tegangan TN';
            $string['form']['tegangan'][1][0]['label']                                    = 'Tegangan RS';
            $string['form']['tegangan'][1][1]['label']                                    = 'Tegangan RT';
            $string['form']['tegangan'][1][2]['label']                                    = 'Tegangan ST';
            $string['form']['jurusan']['umum']['content'][0]['jurusan']['label']          = 'ID Jurusan';
            $string['form']['jurusan']['umum']['content'][1]['jurusan']['label']          = 'ID Jurusan';
            $string['form']['jurusan']['umum']['content'][2]['jurusan']['label']          = 'ID Jurusan';
            $string['form']['jurusan']['umum']['content'][3]['jurusan']['label']          = 'ID Jurusan';
            $string['form']['jurusan']['umum']['content'][0]['arus'][0][0]['label']       = 'Arus R';
            $string['form']['jurusan']['umum']['content'][0]['arus'][0][1]['label']       = 'Arus S';
            $string['form']['jurusan']['umum']['content'][0]['arus'][1][0]['label']       = 'Arus T';
            $string['form']['jurusan']['umum']['content'][0]['arus'][1][1]['label']       = 'Arus N';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][0]['label']   = 'Tegangan RN';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][1]['label']   = 'Tegangan SN';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][2]['label']   = 'Tegangan TN';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][0]['label']   = 'Tegangan RS';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][1]['label']   = 'Tegangan RT';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][2]['label']   = 'Tegangan ST';
            $string['form']['jurusan']['umum']['content'][1]['arus'][0][0]['label']       = 'Arus R';
            $string['form']['jurusan']['umum']['content'][1]['arus'][0][1]['label']       = 'Arus S';
            $string['form']['jurusan']['umum']['content'][1]['arus'][1][0]['label']       = 'Arus T';
            $string['form']['jurusan']['umum']['content'][1]['arus'][1][1]['label']       = 'Arus N';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][0]['label']   = 'Tegangan RN';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][1]['label']   = 'Tegangan SN';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][2]['label']   = 'Tegangan TN';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][0]['label']   = 'Tegangan RS';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][1]['label']   = 'Tegangan RT';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][2]['label']   = 'Tegangan ST';
            $string['form']['jurusan']['umum']['content'][2]['arus'][0][0]['label']       = 'Arus R';
            $string['form']['jurusan']['umum']['content'][2]['arus'][0][1]['label']       = 'Arus S';
            $string['form']['jurusan']['umum']['content'][2]['arus'][1][0]['label']       = 'Arus T';
            $string['form']['jurusan']['umum']['content'][2]['arus'][1][1]['label']       = 'Arus N';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][0]['label']   = 'Tegangan RN';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][1]['label']   = 'Tegangan SN';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][2]['label']   = 'Tegangan TN';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][0]['label']   = 'Tegangan RS';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][1]['label']   = 'Tegangan RT';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][2]['label']   = 'Tegangan ST';
            $string['form']['jurusan']['umum']['content'][3]['arus'][0][0]['label']       = 'Arus R';
            $string['form']['jurusan']['umum']['content'][3]['arus'][0][1]['label']       = 'Arus S';
            $string['form']['jurusan']['umum']['content'][3]['arus'][1][0]['label']       = 'Arus T';
            $string['form']['jurusan']['umum']['content'][3]['arus'][1][1]['label']       = 'Arus N';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][0]['label']   = 'Tegangan RN';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][1]['label']   = 'Tegangan SN';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][2]['label']   = 'Tegangan TN';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][0]['label']   = 'Tegangan RS';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][1]['label']   = 'Tegangan RT';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][2]['label']   = 'Tegangan ST';
            $string['form']['jurusan']['khusus']['content'][0]['jurusan']['label']        = 'ID Jurusan';
            $string['form']['jurusan']['khusus']['content'][1]['jurusan']['label']        = 'ID Jurusan';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][0][0]['label']     = 'Arus R';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][0][1]['label']     = 'Arus S';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][1][0]['label']     = 'Arus T';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][1][1]['label']     = 'Arus N';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][0]['label'] = 'Tegangan RN';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][1]['label'] = 'Tegangan SN';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][2]['label'] = 'Tegangan TN';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][0]['label'] = 'Tegangan RS';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][1]['label'] = 'Tegangan RT';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][2]['label'] = 'Tegangan ST';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][0][0]['label']     = 'Arus R';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][0][1]['label']     = 'Arus S';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][1][0]['label']     = 'Arus T';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][1][1]['label']     = 'Arus N';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][0]['label'] = 'Tegangan RN';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][1]['label'] = 'Tegangan SN';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][2]['label'] = 'Tegangan TN';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][0]['label'] = 'Tegangan RS';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][1]['label'] = 'Tegangan RT';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][2]['label'] = 'Tegangan ST';

            $string['form']['worker']['worker1']['placeholder']                                 = 'Nama Petugas 1';
            $string['form']['worker']['worker2']['placeholder']                                 = 'Nama Petugas 2';
            $string['form']['worker']['contract']['placeholder']                                = 'No. Kontrak';
            $string['form']['arus'][0][0]['placeholder']                                        = 'IR';
            $string['form']['arus'][0][1]['placeholder']                                        = 'IS';
            $string['form']['arus'][1][0]['placeholder']                                        = 'IT';
            $string['form']['arus'][1][1]['placeholder']                                        = 'IN';
            $string['form']['tegangan'][0][0]['placeholder']                                    = 'VRN';
            $string['form']['tegangan'][0][1]['placeholder']                                    = 'VSN';
            $string['form']['tegangan'][0][2]['placeholder']                                    = 'VTN';
            $string['form']['tegangan'][1][0]['placeholder']                                    = 'VRS';
            $string['form']['tegangan'][1][1]['placeholder']                                    = 'VRT';
            $string['form']['tegangan'][1][2]['placeholder']                                    = 'VST';
            $string['form']['jurusan']['umum']['content'][0]['arus'][0][0]['placeholder']       = 'IR';
            $string['form']['jurusan']['umum']['content'][0]['arus'][0][1]['placeholder']       = 'IS';
            $string['form']['jurusan']['umum']['content'][0]['arus'][1][0]['placeholder']       = 'IT';
            $string['form']['jurusan']['umum']['content'][0]['arus'][1][1]['placeholder']       = 'IN';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][0]['placeholder']   = 'VRN';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][1]['placeholder']   = 'VSN';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][2]['placeholder']   = 'VTN';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][0]['placeholder']   = 'VRS';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][1]['placeholder']   = 'VRT';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][2]['placeholder']   = 'VST';
            $string['form']['jurusan']['umum']['content'][1]['arus'][0][0]['placeholder']       = 'IR';
            $string['form']['jurusan']['umum']['content'][1]['arus'][0][1]['placeholder']       = 'IS';
            $string['form']['jurusan']['umum']['content'][1]['arus'][1][0]['placeholder']       = 'IT';
            $string['form']['jurusan']['umum']['content'][1]['arus'][1][1]['placeholder']       = 'IN';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][0]['placeholder']   = 'VRN';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][1]['placeholder']   = 'VSN';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][2]['placeholder']   = 'VTN';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][0]['placeholder']   = 'VRS';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][1]['placeholder']   = 'VRT';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][2]['placeholder']   = 'VST';
            $string['form']['jurusan']['umum']['content'][2]['arus'][0][0]['placeholder']       = 'IR';
            $string['form']['jurusan']['umum']['content'][2]['arus'][0][1]['placeholder']       = 'IS';
            $string['form']['jurusan']['umum']['content'][2]['arus'][1][0]['placeholder']       = 'IT';
            $string['form']['jurusan']['umum']['content'][2]['arus'][1][1]['placeholder']       = 'IN';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][0]['placeholder']   = 'VRN';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][1]['placeholder']   = 'VSN';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][2]['placeholder']   = 'VTN';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][0]['placeholder']   = 'VRS';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][1]['placeholder']   = 'VRT';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][2]['placeholder']   = 'VST';
            $string['form']['jurusan']['umum']['content'][3]['arus'][0][0]['placeholder']       = 'IR';
            $string['form']['jurusan']['umum']['content'][3]['arus'][0][1]['placeholder']       = 'IS';
            $string['form']['jurusan']['umum']['content'][3]['arus'][1][0]['placeholder']       = 'IT';
            $string['form']['jurusan']['umum']['content'][3]['arus'][1][1]['placeholder']       = 'IN';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][0]['placeholder']   = 'VRN';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][1]['placeholder']   = 'VSN';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][2]['placeholder']   = 'VTN';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][0]['placeholder']   = 'VRS';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][1]['placeholder']   = 'VRT';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][2]['placeholder']   = 'VST';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][0][0]['placeholder']     = 'IR';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][0][1]['placeholder']     = 'IS';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][1][0]['placeholder']     = 'IT';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][1][1]['placeholder']     = 'IN';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][0]['placeholder'] = 'VRN';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][1]['placeholder'] = 'VSN';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][2]['placeholder'] = 'VTN';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][0]['placeholder'] = 'VRS';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][1]['placeholder'] = 'VRT';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][2]['placeholder'] = 'VST';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][0][0]['placeholder']     = 'IR';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][0][1]['placeholder']     = 'IS';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][1][0]['placeholder']     = 'IT';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][1][1]['placeholder']     = 'IN';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][0]['placeholder'] = 'VRN';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][1]['placeholder'] = 'VSN';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][2]['placeholder'] = 'VTN';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][0]['placeholder'] = 'VRS';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][1]['placeholder'] = 'VRT';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][2]['placeholder'] = 'VST';

            $string['form']['no_gardu']['id']                                          = 'no_gardu';
            $string['form']['date']['id']                                              = 'date';
            $string['form']['time']['id']                                              = 'time';
            $string['form']['worker']['worker1']['id']                                 = 'petugas1';
            $string['form']['worker']['worker2']['id']                                 = 'petugas2';
            $string['form']['worker']['contract']['id']                                = 'no_kontrak';
            $string['form']['arus'][0][0]['id']                                        = 'ir';
            $string['form']['arus'][0][1]['id']                                        = 'is';
            $string['form']['arus'][1][0]['id']                                        = 'it';
            $string['form']['arus'][1][1]['id']                                        = 'in';
            $string['form']['tegangan'][0][0]['id']                                    = 'vrn';
            $string['form']['tegangan'][0][1]['id']                                    = 'vsn';
            $string['form']['tegangan'][0][2]['id']                                    = 'vtn';
            $string['form']['tegangan'][1][0]['id']                                    = 'vrs';
            $string['form']['tegangan'][1][1]['id']                                    = 'vrt';
            $string['form']['tegangan'][1][2]['id']                                    = 'vst';
            $string['form']['jurusan']['umum']['content'][0]['id']                     = 'umum1';
            $string['form']['jurusan']['umum']['content'][1]['id']                     = 'umum2';
            $string['form']['jurusan']['umum']['content'][2]['id']                     = 'umum3';
            $string['form']['jurusan']['umum']['content'][3]['id']                     = 'umum4';
            $string['form']['jurusan']['umum']['content'][0]['jurusan']['id']          = 'j_u1';
            $string['form']['jurusan']['umum']['content'][1]['jurusan']['id']          = 'j_u2';
            $string['form']['jurusan']['umum']['content'][2]['jurusan']['id']          = 'j_u3';
            $string['form']['jurusan']['umum']['content'][3]['jurusan']['id']          = 'j_u4';
            $string['form']['jurusan']['umum']['content'][0]['arus'][0][0]['id']       = 'ir_u1';
            $string['form']['jurusan']['umum']['content'][0]['arus'][0][1]['id']       = 'is_u1';
            $string['form']['jurusan']['umum']['content'][0]['arus'][1][0]['id']       = 'it_u1';
            $string['form']['jurusan']['umum']['content'][0]['arus'][1][1]['id']       = 'in_u1';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][0]['id']   = 'vrn_u1';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][1]['id']   = 'vsn_u1';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][0][2]['id']   = 'vtn_u1';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][0]['id']   = 'vrs_u1';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][1]['id']   = 'vrt_u1';
            $string['form']['jurusan']['umum']['content'][0]['tegangan'][1][2]['id']   = 'vst_u1';
            $string['form']['jurusan']['umum']['content'][1]['arus'][0][0]['id']       = 'ir_u2';
            $string['form']['jurusan']['umum']['content'][1]['arus'][0][1]['id']       = 'is_u2';
            $string['form']['jurusan']['umum']['content'][1]['arus'][1][0]['id']       = 'it_u2';
            $string['form']['jurusan']['umum']['content'][1]['arus'][1][1]['id']       = 'in_u2';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][0]['id']   = 'vrn_u2';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][1]['id']   = 'vsn_u2';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][0][2]['id']   = 'vtn_u2';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][0]['id']   = 'vrs_u2';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][1]['id']   = 'vrt_u2';
            $string['form']['jurusan']['umum']['content'][1]['tegangan'][1][2]['id']   = 'vst_u2';
            $string['form']['jurusan']['umum']['content'][2]['arus'][0][0]['id']       = 'ir_u3';
            $string['form']['jurusan']['umum']['content'][2]['arus'][0][1]['id']       = 'is_u3';
            $string['form']['jurusan']['umum']['content'][2]['arus'][1][0]['id']       = 'it_u3';
            $string['form']['jurusan']['umum']['content'][2]['arus'][1][1]['id']       = 'in_u3';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][0]['id']   = 'vrn_u3';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][1]['id']   = 'vsn_u3';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][0][2]['id']   = 'vtn_u3';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][0]['id']   = 'vrs_u3';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][1]['id']   = 'vrt_u3';
            $string['form']['jurusan']['umum']['content'][2]['tegangan'][1][2]['id']   = 'vst_u3';
            $string['form']['jurusan']['umum']['content'][3]['arus'][0][0]['id']       = 'ir_u4';
            $string['form']['jurusan']['umum']['content'][3]['arus'][0][1]['id']       = 'is_u4';
            $string['form']['jurusan']['umum']['content'][3]['arus'][1][0]['id']       = 'it_u4';
            $string['form']['jurusan']['umum']['content'][3]['arus'][1][1]['id']       = 'in_u4';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][0]['id']   = 'vrn_u4';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][1]['id']   = 'vsn_u4';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][0][2]['id']   = 'vtn_u4';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][0]['id']   = 'vrs_u4';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][1]['id']   = 'vrt_u4';
            $string['form']['jurusan']['umum']['content'][3]['tegangan'][1][2]['id']   = 'vst_u4';
            $string['form']['jurusan']['khusus']['content'][0]['id']                   = 'khusus1';
            $string['form']['jurusan']['khusus']['content'][1]['id']                   = 'khusus2';
            $string['form']['jurusan']['khusus']['content'][0]['jurusan']['id']        = 'j_k1';
            $string['form']['jurusan']['khusus']['content'][1]['jurusan']['id']        = 'j_k2';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][0][0]['id']     = 'ir_k1';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][0][1]['id']     = 'is_k1';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][1][0]['id']     = 'it_k1';
            $string['form']['jurusan']['khusus']['content'][0]['arus'][1][1]['id']     = 'in_k1';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][0]['id'] = 'vrn_k1';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][1]['id'] = 'vsn_k1';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][0][2]['id'] = 'vtn_k1';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][0]['id'] = 'vrs_k1';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][1]['id'] = 'vrt_k1';
            $string['form']['jurusan']['khusus']['content'][0]['tegangan'][1][2]['id'] = 'vst_k1';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][0][0]['id']     = 'ir_k2';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][0][1]['id']     = 'is_k2';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][1][0]['id']     = 'it_k2';
            $string['form']['jurusan']['khusus']['content'][1]['arus'][1][1]['id']     = 'in_k2';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][0]['id'] = 'vrn_k2';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][1]['id'] = 'vsn_k2';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][0][2]['id'] = 'vtn_k2';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][0]['id'] = 'vrs_k2';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][1]['id'] = 'vrt_k2';
            $string['form']['jurusan']['khusus']['content'][1]['tegangan'][1][2]['id'] = 'vst_k2';


            $string['form']['create_gardu_index']['link'] = site_url('/gardu/');
            $string['form']['dashboard']['link']          = site_url('/dashboard');


            $string['form']['create_gardu_index']['description'] = 'Masukkan Data Gardu Baru';

            $string['form']['button']['go_back'] = 'Kembali';
            $string['form']['button']['reset']   = 'Reset';
            $string['form']['button']['submit']  = 'Simpan';


            $meta['retriever'] = site_url('/api/gardu/index/find?code=B231A');

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
                    , 'redirector' => site_url("/gardu/pengukuran")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }
}

?>

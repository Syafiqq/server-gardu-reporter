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

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('cookie');
        $this->load->database();
        /** @noinspection PhpParamsInspection */
        $this->load->library(['ion_auth', 'session']);

        $this->language = empty($this->language = get_cookie('common_language')) ? $this->config->item('language') : $this->language;
        $this->country = empty($this->country = get_cookie('common_country')) ? $this->config->item('country') : $this->country;
    }

    public function index()
    {
        $this->load->helper(['url', 'i18n']);
        $group = $this->session->userdata('group');
        $group = empty($group) ? 'admin' : $group;
        switch ($group)
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

    public function _index_admin()
    {
        $this->lang_prefix = 'gardu_index_admin';
        $this->lang_layout = 'common_layout';
        $this->lang_prefix_path = 'gardu/index/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);
        $this->lang->load("layout/gardu/index/gardu_index_common", $this->language);

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
            $meta = [];
            $data = [];
            $view = [];

            $_user = $this->ion_auth->user()->row_array();
            $data['profile']['username'] = $_user['username'];
            $data['profile']['email'] = $_user['email'];
            $data['profile']['group'] = 'Admin';
            $data['update']['redirector'] = site_url('/management/user');

            //Core Data
            $string['title'] = $this->lang->line('common_title');
            $string['page_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_page_title");
            $string['auth_logout'] = $this->lang->line('common_auth_common_logout');
            $string['profile_edit'] = $this->lang->line('common_profile_common_edit_button');

            //Sidebar
            $string['sidebar_home'] = $this->lang->line('common_sidebar_common_sidebar_home');
            $string['sidebar_recapitulation'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation');
            $string['sidebar_recapitulation_measurement'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_measurement');
            $string['sidebar_recapitulation_voltage_end'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_voltage_end');
            $string['sidebar_recapitulation_travo_load'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_travo_load');
            $string['sidebar_recapitulation_load_balance'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_load_balance');
            $string['sidebar_info_gardu'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu');
            $string['sidebar_info_gardu_hq'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_hq');
            $string['sidebar_info_gardu_feeder'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_feeder');
            $string['sidebar_info_gardu_data'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_data');
            $string['sidebar_info_user_management'] = $this->lang->line('common_sidebar_common_sidebar_info_user_management');

            //Profile
            $string['client_register'] = $this->lang->line('common_auth_common_register');
            $string['client_form_username_label'] = $this->lang->line('common_auth_register_form_username_label');
            $string['client_form_email_label'] = $this->lang->line('common_auth_register_form_email_label');
            $string['client_form_role_label'] = $this->lang->line('common_auth_register_form_role_label');
            $string['client_form_username_placeholder'] = $this->lang->line("common_profile_edit_common_client_username_placeholder");
            $string['client_form_email_placeholder'] = $this->lang->line("common_profile_edit_common_client_email_placeholder");
            $string['inline_client_form_id_id'] = 'id';
            $string['inline_client_form_username_id'] = 'username';
            $string['inline_client_form_email_id'] = 'email';
            $string['inline_client_form_role_id'] = 'role';

            //Item Creation Form
            $string['item_creation_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_title");
            $string['item_creation_register'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_button");
            $string['item_creation_reset'] = $this->lang->line('common_auth_common_reset');

            $string['item_creation_form_induk_id_label'] = $this->lang->line("gardu_index_common_form_induk_id_label");
            $string['item_creation_form_penyulang_id_label'] = $this->lang->line("gardu_index_common_form_penyulang_id_label");
            $string['item_creation_form_jenis_label'] = $this->lang->line("gardu_index_common_form_jenis_label");
            $string['item_creation_form_no_label'] = $this->lang->line("gardu_index_common_form_no_label");
            $string['item_creation_form_lokasi_label'] = $this->lang->line("gardu_index_common_form_lokasi_label");
            $string['item_creation_form_merk_label'] = $this->lang->line("gardu_index_common_form_merk_label");
            $string['item_creation_form_serial_label'] = $this->lang->line("gardu_index_common_form_serial_label");
            $string['item_creation_form_daya_label'] = $this->lang->line("gardu_index_common_form_daya_label");
            $string['item_creation_form_fasa_label'] = $this->lang->line("gardu_index_common_form_fasa_label");
            $string['item_creation_form_tap_label'] = $this->lang->line("gardu_index_common_form_tap_label");
            $string['item_creation_form_jurusan_label'] = $this->lang->line("gardu_index_common_form_jurusan_label");
            $string['item_creation_form_lat_label'] = $this->lang->line("gardu_index_common_form_lat_label");
            $string['item_creation_form_long_label'] = $this->lang->line("gardu_index_common_form_long_label");

            $string['item_creation_form_induk_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_induk_id_placeholder");
            $string['item_creation_form_penyulang_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_penyulang_id_placeholder");
            $string['item_creation_form_jenis_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_jenis_placeholder");
            $string['item_creation_form_no_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_no_placeholder");
            $string['item_creation_form_lokasi_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_lokasi_placeholder");
            $string['item_creation_form_merk_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_merk_placeholder");
            $string['item_creation_form_serial_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_serial_placeholder");
            $string['item_creation_form_daya_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_daya_placeholder");
            $string['item_creation_form_fasa_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_fasa_placeholder");
            $string['item_creation_form_tap_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_tap_placeholder");
            $string['item_creation_form_jurusan_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_jurusan_placeholder");
            $string['item_creation_form_lat_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_lat_placeholder");
            $string['item_creation_form_long_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_long_placeholder");

            $string['item_creation_form_id_induk_id'] = 'induk_id';
            $string['item_creation_form_id_penyulang_id'] = 'penyulang_id';
            $string['item_creation_form_id_jenis'] = 'jenis';
            $string['item_creation_form_id_no'] = 'no';
            $string['item_creation_form_id_lokasi'] = 'lokasi';
            $string['item_creation_form_id_merk'] = 'merk';
            $string['item_creation_form_id_serial'] = 'serial';
            $string['item_creation_form_id_daya'] = 'daya';
            $string['item_creation_form_id_fasa'] = 'fasa';
            $string['item_creation_form_id_tap'] = 'tap';
            $string['item_creation_form_id_jurusan'] = 'jurusan';
            $string['item_creation_form_id_lat'] = 'lat';
            $string['item_creation_form_id_long'] = 'long';

            $string['item_manipulation_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_title");
            $string['item_manipulation_update'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_button");
            $string['item_manipulation_detail'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_detail");
            $string['item_manipulation_reset'] = $string['item_creation_reset'];


            $string['item_manipulation_form_induk_id_label'] = $this->lang->line("gardu_index_common_form_induk_id_label");
            $string['item_manipulation_form_penyulang_id_label'] = $this->lang->line("gardu_index_common_form_penyulang_id_label");
            $string['item_manipulation_form_jenis_label'] = $this->lang->line("gardu_index_common_form_jenis_label");
            $string['item_manipulation_form_no_label'] = $this->lang->line("gardu_index_common_form_no_label");
            $string['item_manipulation_form_lokasi_label'] = $this->lang->line("gardu_index_common_form_lokasi_label");
            $string['item_manipulation_form_merk_label'] = $this->lang->line("gardu_index_common_form_merk_label");
            $string['item_manipulation_form_serial_label'] = $this->lang->line("gardu_index_common_form_serial_label");
            $string['item_manipulation_form_daya_label'] = $this->lang->line("gardu_index_common_form_daya_label");
            $string['item_manipulation_form_fasa_label'] = $this->lang->line("gardu_index_common_form_fasa_label");
            $string['item_manipulation_form_tap_label'] = $this->lang->line("gardu_index_common_form_tap_label");
            $string['item_manipulation_form_jurusan_label'] = $this->lang->line("gardu_index_common_form_jurusan_label");
            $string['item_manipulation_form_lat_label'] = $this->lang->line("gardu_index_common_form_lat_label");
            $string['item_manipulation_form_long_label'] = $this->lang->line("gardu_index_common_form_long_label");

            $string['item_manipulation_form_induk_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_induk_id_placeholder");
            $string['item_manipulation_form_penyulang_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_penyulang_id_placeholder");
            $string['item_manipulation_form_jenis_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_jenis_placeholder");
            $string['item_manipulation_form_no_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_no_placeholder");
            $string['item_manipulation_form_lokasi_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_lokasi_placeholder");
            $string['item_manipulation_form_merk_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_merk_placeholder");
            $string['item_manipulation_form_serial_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_serial_placeholder");
            $string['item_manipulation_form_daya_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_daya_placeholder");
            $string['item_manipulation_form_fasa_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_fasa_placeholder");
            $string['item_manipulation_form_tap_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_tap_placeholder");
            $string['item_manipulation_form_jurusan_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_jurusan_placeholder");
            $string['item_manipulation_form_lat_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_lat_placeholder");
            $string['item_manipulation_form_long_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_manipulation_form_long_placeholder");

            $string['item_manipulation_form_id_induk_id'] = 'induk_id';
            $string['item_manipulation_form_id_penyulang_id'] = 'penyulang_id';
            $string['item_manipulation_form_id_jenis'] = 'jenis';
            $string['item_manipulation_form_id_no'] = 'no';
            $string['item_manipulation_form_id_lokasi'] = 'lokasi';
            $string['item_manipulation_form_id_merk'] = 'merk';
            $string['item_manipulation_form_id_serial'] = 'serial';
            $string['item_manipulation_form_id_daya'] = 'daya';
            $string['item_manipulation_form_id_fasa'] = 'fasa';
            $string['item_manipulation_form_id_tap'] = 'tap';
            $string['item_manipulation_form_id_jurusan'] = 'jurusan';
            $string['item_manipulation_form_id_lat'] = 'lat';
            $string['item_manipulation_form_id_long'] = 'long';

            //Table
            $string['add_new_item'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_add_new_item");

            $string['table_header_induk_id'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_induk_id");
            $string['table_header_penyulang_id'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_penyulang_id");
            $string['table_header_no'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_no");
            $string['table_header_location'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_location");
            $string['table_header_option'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_option");

            $meta['retriever'] = site_url('/api/gardu/index/find?code=FE37A');
            $meta['induk_retriever'] = site_url('/api/gardu/induk/find?code=C41AF');
            $meta['penyulang_retriever'] = site_url('/api/gardu/penyulang/find?code=B28FE');
            $meta['deleter'] = site_url('/api/gardu/index/delete');
            $meta['editer'] = site_url('/api/gardu/index/update');
            $meta['detail'] = site_url('/gardu/detail?gardu=%s');
            $meta['datatable_lang'] = base_url($this->lang->line('common_datatable_lang'));

            $data['meta']['i18n']['country'] = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata'] = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

            $_properties = compact('meta', 'string', 'data');

            $view['sidebar'] = $this->load->view("common/common_menus_{$this->lang_layout}", $_properties, true);
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
                    , 'redirector' => site_url("/{$this->lang_prefix_path}")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _index_member()
    {

    }

    public function induk()
    {
        $this->load->helper(['url', 'i18n']);
        $group = $this->session->userdata('group');
        $group = empty($group) ? 'admin' : $group;
        switch ($group)
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
        $this->lang_prefix = 'gardu_induk_admin';
        $this->lang_layout = 'common_layout';
        $this->lang_prefix_path = 'gardu/induk/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);

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
            $meta = [];
            $data = [];
            $view = [];

            $_user = $this->ion_auth->user()->row_array();
            $data['profile']['username'] = $_user['username'];
            $data['profile']['email'] = $_user['email'];
            $data['profile']['group'] = 'Admin';
            $data['update']['redirector'] = site_url('/management/user');

            //Core Data
            $string['title'] = $this->lang->line('common_title');
            $string['page_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_page_title");
            $string['auth_logout'] = $this->lang->line('common_auth_common_logout');
            $string['profile_edit'] = $this->lang->line('common_profile_common_edit_button');

            //Sidebar
            $string['sidebar_home'] = $this->lang->line('common_sidebar_common_sidebar_home');
            $string['sidebar_recapitulation'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation');
            $string['sidebar_recapitulation_measurement'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_measurement');
            $string['sidebar_recapitulation_voltage_end'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_voltage_end');
            $string['sidebar_recapitulation_travo_load'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_travo_load');
            $string['sidebar_recapitulation_load_balance'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_load_balance');
            $string['sidebar_info_gardu'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu');
            $string['sidebar_info_gardu_hq'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_hq');
            $string['sidebar_info_gardu_feeder'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_feeder');
            $string['sidebar_info_gardu_data'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_data');
            $string['sidebar_info_user_management'] = $this->lang->line('common_sidebar_common_sidebar_info_user_management');

            //Profile
            $string['client_register'] = $this->lang->line('common_auth_common_register');
            $string['client_form_username_label'] = $this->lang->line('common_auth_register_form_username_label');
            $string['client_form_email_label'] = $this->lang->line('common_auth_register_form_email_label');
            $string['client_form_role_label'] = $this->lang->line('common_auth_register_form_role_label');
            $string['client_form_username_placeholder'] = $this->lang->line("common_profile_edit_common_client_username_placeholder");
            $string['client_form_email_placeholder'] = $this->lang->line("common_profile_edit_common_client_email_placeholder");
            $string['inline_client_form_id_id'] = 'id';
            $string['inline_client_form_username_id'] = 'username';
            $string['inline_client_form_email_id'] = 'email';
            $string['inline_client_form_role_id'] = 'role';

            //Item Creation Form
            $string['item_creation_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_title");
            $string['item_creation_register'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_button");
            $string['item_creation_reset'] = $this->lang->line('common_auth_common_reset');
            $string['item_creation_form_id_label'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_label");
            $string['item_creation_form_name_label'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_label");
            $string['item_creation_form_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_placeholder");
            $string['item_creation_form_name_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_placeholder");
            $string['item_creation_form_id_id'] = 'id';
            $string['item_creation_form_name_id'] = 'name';
            $string['item_manipulation_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_title");
            $string['item_manipulation_update'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_button");
            $string['item_manipulation_reset'] = $string['item_creation_reset'];
            $string['item_manipulation_form_id_label'] = $string['item_creation_form_id_label'];
            $string['item_manipulation_form_name_label'] = $string['item_creation_form_name_label'];
            $string['item_manipulation_form_name_placeholder'] = $string['item_creation_form_name_placeholder'];
            $string['item_manipulation_form_id_id'] = $string['item_creation_form_id_id'];
            $string['item_manipulation_form_name_id'] = $string['item_creation_form_name_id'];

            //Table
            $string['add_new_item'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_add_new_item");
            $string['table_header_code'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_code");
            $string['table_header_name'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_name");
            $string['table_header_option'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_option");

            $meta['retriever'] = site_url('/api/gardu/induk/find?code=C41AF');
            $meta['deleter'] = site_url('/api/gardu/induk/delete');
            $meta['editer'] = site_url('/api/gardu/induk/update');
            $meta['datatable_lang'] = base_url($this->lang->line('common_datatable_lang'));

            $data['meta']['i18n']['country'] = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata'] = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

            $_properties = compact('meta', 'string', 'data');

            $view['sidebar'] = $this->load->view("common/common_menus_{$this->lang_layout}", $_properties, true);
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
                    , 'redirector' => site_url("/{$this->lang_prefix_path}")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _induk_member()
    {
    }

    public function penyulang()
    {
        $this->load->helper(['url', 'i18n']);
        $group = $this->session->userdata('group');
        $group = empty($group) ? 'admin' : $group;
        switch ($group)
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

    public function _penyulang_admin()
    {
        $this->lang_prefix = 'gardu_penyulang_admin';
        $this->lang_layout = 'common_layout';
        $this->lang_prefix_path = 'gardu/penyulang/admin';
        $this->lang->load("layout/{$this->lang_prefix_path}/{$this->lang_prefix}_{$this->lang_layout}", $this->language);

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
            $meta = [];
            $data = [];
            $view = [];

            $_user = $this->ion_auth->user()->row_array();
            $data['profile']['username'] = $_user['username'];
            $data['profile']['email'] = $_user['email'];
            $data['profile']['group'] = 'Admin';
            $data['update']['redirector'] = site_url('/management/user');

            //Core Data
            $string['title'] = $this->lang->line('common_title');
            $string['page_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_page_title");
            $string['auth_logout'] = $this->lang->line('common_auth_common_logout');
            $string['profile_edit'] = $this->lang->line('common_profile_common_edit_button');

            //Sidebar
            $string['sidebar_home'] = $this->lang->line('common_sidebar_common_sidebar_home');
            $string['sidebar_recapitulation'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation');
            $string['sidebar_recapitulation_measurement'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_measurement');
            $string['sidebar_recapitulation_voltage_end'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_voltage_end');
            $string['sidebar_recapitulation_travo_load'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_travo_load');
            $string['sidebar_recapitulation_load_balance'] = $this->lang->line('common_sidebar_common_sidebar_recapitulation_load_balance');
            $string['sidebar_info_gardu'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu');
            $string['sidebar_info_gardu_hq'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_hq');
            $string['sidebar_info_gardu_feeder'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_feeder');
            $string['sidebar_info_gardu_data'] = $this->lang->line('common_sidebar_common_sidebar_info_gardu_data');
            $string['sidebar_info_user_management'] = $this->lang->line('common_sidebar_common_sidebar_info_user_management');

            //Profile
            $string['client_register'] = $this->lang->line('common_auth_common_register');
            $string['client_form_username_label'] = $this->lang->line('common_auth_register_form_username_label');
            $string['client_form_email_label'] = $this->lang->line('common_auth_register_form_email_label');
            $string['client_form_role_label'] = $this->lang->line('common_auth_register_form_role_label');
            $string['client_form_username_placeholder'] = $this->lang->line("common_profile_edit_common_client_username_placeholder");
            $string['client_form_email_placeholder'] = $this->lang->line("common_profile_edit_common_client_email_placeholder");
            $string['inline_client_form_id_id'] = 'id';
            $string['inline_client_form_username_id'] = 'username';
            $string['inline_client_form_email_id'] = 'email';
            $string['inline_client_form_role_id'] = 'role';

            //Item Creation Form
            $string['item_creation_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_title");
            $string['item_creation_register'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_register_new_item_button");
            $string['item_creation_reset'] = $this->lang->line('common_auth_common_reset');
            $string['item_creation_form_id_label'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_label");
            $string['item_creation_form_name_label'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_label");
            $string['item_creation_form_id_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_id_placeholder");
            $string['item_creation_form_name_placeholder'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_item_creation_form_name_placeholder");
            $string['item_creation_form_id_id'] = 'id';
            $string['item_creation_form_name_id'] = 'name';
            $string['item_manipulation_title'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_title");
            $string['item_manipulation_update'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_update_existing_item_button");
            $string['item_manipulation_reset'] = $string['item_creation_reset'];
            $string['item_manipulation_form_id_label'] = $string['item_creation_form_id_label'];
            $string['item_manipulation_form_name_label'] = $string['item_creation_form_name_label'];
            $string['item_manipulation_form_name_placeholder'] = $string['item_creation_form_name_placeholder'];
            $string['item_manipulation_form_id_id'] = $string['item_creation_form_id_id'];
            $string['item_manipulation_form_name_id'] = $string['item_creation_form_name_id'];

            //Table
            $string['add_new_item'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_add_new_item");
            $string['table_header_code'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_code");
            $string['table_header_name'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_name");
            $string['table_header_option'] = $this->lang->line("{$this->lang_prefix}_{$this->lang_layout}_table_header_option");

            $meta['retriever'] = site_url('/api/gardu/penyulang/find?code=B28FE');
            $meta['deleter'] = site_url('/api/gardu/penyulang/delete');
            $meta['editer'] = site_url('/api/gardu/penyulang/update');
            $meta['datatable_lang'] = base_url($this->lang->line('common_datatable_lang'));

            $data['meta']['i18n']['country'] = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata'] = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

            $_properties = compact('meta', 'string', 'data');

            $view['sidebar'] = $this->load->view("common/common_menus_{$this->lang_layout}", $_properties, true);
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
                    , 'redirector' => site_url("/{$this->lang_prefix_path}")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _penyulang_memeber()
    {

    }
}

?>

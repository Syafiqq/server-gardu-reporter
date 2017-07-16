<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 16 July 2017, 1:23 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Loader load
 * @property CI_Lang lang
 * @property Ion_auth ion_auth
 * @property CI_Config config
 * @property CI_Session session
 */
class Dashboard extends CI_Controller
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
     * @var string $lang_prefix_path
     */
    private $language;
    private $country;
    private $lang_prefix;
    private $lang_prefix_path;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('cookie');
        $this->load->database();
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
                return $this->_admin_index();
            }
            break;
            case 'members':
            {
                return $this->_members_index();
            }
            break;
            default :
            {
                show_404();
            }
        }
    }

    private function _admin_index()
    {
        $this->lang_prefix = 'dashboard_index_admin';
        $this->lang_prefix_path = 'dashboard/index/admin';
        $this->lang->load("layout/$this->lang_prefix_path/{$this->lang_prefix}_common_layout", $this->language);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $this->load->helper('form');

            $this->lang->load('common/auth/common_auth_common', $this->language);
            $this->lang->load('common/profile/common_profile_common', $this->language);
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

            $string['title'] = $this->lang->line('common_title');
            $string['welcome_message'] = sprintf($this->lang->line('dashboard_index_admin_common_layout_welcome_message'), $data['profile']['username']);
            $string['page_title'] = $this->lang->line("{$this->lang_prefix}_common_layout_page_title");
            $string['profile_edit'] = $this->lang->line('common_profile_common_edit_button');
            $string['auth_logout'] = $this->lang->line('common_auth_common_logout');
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

            $string['client_register'] = $this->lang->line('common_auth_common_register');
            $string['client_form_username_label'] = $this->lang->line('common_auth_register_form_username_label');
            $string['client_form_email_label'] = $this->lang->line('common_auth_register_form_email_label');
            $string['client_form_role_label'] = $this->lang->line('common_auth_register_form_role_label');
            $string['client_form_username_placeholder'] = $this->lang->line("{$this->lang_prefix}_common_layout_register_client_username_placeholder");
            $string['client_form_email_placeholder'] = $this->lang->line("{$this->lang_prefix}_common_layout_register_client_email_placeholder");
            $string['inline_client_form_id_id'] = 'id';
            $string['inline_client_form_username_id'] = 'username';
            $string['inline_client_form_email_id'] = 'email';
            $string['inline_client_form_role_id'] = 'role';

            $data['meta']['i18n']['country'] = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata'] = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

            $_properties = compact('meta', 'string', 'data');

            $view['sidebar'] = $this->load->view('common/common_menus_common_layout', $_properties, true);
            $view['edit_profile'] = $this->load->view('common/profile/common_profile_edit_common_layout', $_properties, true);

            $_properties['view'] = $view;
            $this->load->view("{$this->lang_prefix_path}/{$this->lang_prefix}_common_layout", $_properties);
        }
        else
        {
            $this->session->set_flashdata([
                'flashdata' => [
                    'message' => [
                        $this->lang->line("{$this->lang_prefix}_common_layout_forbidden_access"),
                        $this->lang->line("{$this->lang_prefix}_common_layout_forbidden_access_auth_redirection")
                    ]
                    , 'redirector' => site_url("/{$this->lang_prefix_path}")
                ]
            ]);
            redirect('/auth/login/admin');
        }
    }

    private function _members_index()
    {

    }
}

?>

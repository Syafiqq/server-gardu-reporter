<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 30 June 2017, 6:36 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Config config
 * @property CI_Lang lang
 * @property Ion_auth ion_auth
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
     */
    private $language;
    private $country;
    private $lang_prefix;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('cookie');

        $this->language = empty($this->language = get_cookie('common_language')) ? $this->config->item('language') : $this->language;
        $this->country = empty($this->country = get_cookie('common_country')) ? $this->config->item('country') : $this->country;
    }

    public function register()
    {
        $this->load->database();
        $this->load->library(['ion_auth', 'session']);
        $this->load->helper(['url', 'i18n', 'form']);
        $this->lang_prefix = 'admin_dashboard_register';
        $this->lang->load("layout/admin/dashboard/register/{$this->lang_prefix}_common_layout", $this->language);

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $this->lang->load('common/auth/common_auth_common', $this->language);
            $this->lang->load('common/auth/common_auth_register_form', $this->language);
            $this->lang->load('common', $this->language);

            $string = [];
            $meta = [];
            $data = [];

            $string['title'] = $this->lang->line('common_title');
            $string['client_register'] = $this->lang->line('common_auth_common_register');
            $string['client_form_username_label'] = $this->lang->line('common_auth_register_form_username_label');
            $string['client_form_email_label'] = $this->lang->line('common_auth_register_form_email_label');
            $string['client_form_password_label'] = $this->lang->line('common_auth_register_form_password_label');
            $string['client_form_password_confirmation_label'] = $this->lang->line('common_auth_register_form_password_confirmation_label');
            $string['client_form_username_placeholder'] = $this->lang->line("{$this->lang_prefix}_common_layout_register_client_username_placeholder");
            $string['client_form_email_placeholder'] = $this->lang->line("{$this->lang_prefix}_common_layout_register_client_email_placeholder");
            $string['client_form_password_placeholder'] = $this->lang->line("{$this->lang_prefix}_common_layout_register_client_password_placeholder");
            $string['client_form_password_confirmation_placeholder'] = $this->lang->line("{$this->lang_prefix}_common_layout_register_client_password_confirmation_placeholder");
            $string['inline_client_form_username_id'] = 'username';
            $string['inline_client_form_email_id'] = 'email';
            $string['inline_client_form_password_id'] = 'password';
            $string['inline_client_form_password_confirmation_id'] = 'password_confirmation';

            $data['meta']['i18n']['country'] = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata'] = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

            $this->load->view("admin/dashboard/register/{$this->lang_prefix}_common_layout", compact('meta', 'string', 'data'));
        }
        else
        {
            $this->session->set_flashdata([
                'flashdata' => [
                    'message' => [
                        $this->lang->line("{$this->lang_prefix}_common_layout_register_client_forbidden_access"),
                        $this->lang->line("{$this->lang_prefix}_common_layout_register_client_forbidden_access_auth_redirection")
                    ]
                    , 'redirector' => site_url('/admin/dashboard/register')
                ]
            ]);
            redirect('/admin/auth/login');
        }
    }
}

?>

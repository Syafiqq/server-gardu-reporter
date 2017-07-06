<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 28 June 2017, 6:08 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Lang lang
 * @property Ion_auth ion_auth
 * @property CI_Config config
 * @property CI_Session session
 */
class Auth extends CI_Controller
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

    public function login()
    {
        $this->load->database();
        $this->load->library(['ion_auth', 'session']);
        $this->load->helper(['url', 'i18n', 'form']);

        if ($this->ion_auth->logged_in())
        {
            $this->_logout();
        }
        else
        {
            $this->lang_prefix = 'admin_auth_login';

            $this->lang->load("layout/admin/auth/login/{$this->lang_prefix}_common_layout", $this->language);
            $this->lang->load('common/auth/common_auth_common', $this->language);
            $this->lang->load('common/auth/common_auth_login', $this->language);
            $this->lang->load('common/auth/common_auth_login_form', $this->language);
            $this->lang->load('common', $this->language);

            $string = [];
            $meta = [];
            $data = [];

            $string['title'] = $this->lang->line('common_title');
            $string['login_identity'] = $this->lang->line('common_auth_login_form_email_label');
            $string['login_password'] = $this->lang->line('common_auth_login_form_password_label');
            $string['login_remember_me'] = $this->lang->line('common_auth_login_form_remember_me_label');
            $string['login_submit'] = $this->lang->line('common_auth_common_login');
            $string['login_box_message'] = sprintf($this->lang->line('common_auth_login_login_box_message'), $string['login_submit']);

            $data['meta']['i18n']['country'] = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
            $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
            $data['session']['flashdata'] = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];
            $data['session']['redirector'] = empty(@$this->session->userdata('flashdata')['redirector']) ? null : $this->session->userdata('flashdata')['redirector'];

            $this->load->view("admin/auth/login/{$this->lang_prefix}_common_layout", compact('meta', 'string', 'data'));
        }
    }

    private function _logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('/admin/auth/login', 'refresh');
    }
}

?>

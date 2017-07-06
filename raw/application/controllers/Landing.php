<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 20 June 2017, 3:07 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Landing
 * @property CI_Config config
 * @property CI_Lang lang
 * @property CI_Loader load
 * @property CI_Session session
 */
class Landing extends CI_Controller
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

    public function index()
    {
        $this->load->library('session');
        $this->load->helper(['url', 'i18n']);
        $this->lang_prefix = 'landing_index_client_common_layout_';

        $this->lang->load('layout/landing/index/landing_index_client_common_layout', $this->language);
        $this->lang->load('common/table/common_table_header', $this->language);
        $this->lang->load('common/auth/common_auth_common', $this->language);
        $this->lang->load('common', $this->language);

        $string = [];
        $meta = [];
        $data = [];

        $string['title'] = $this->lang->line('common_title');
        $string['table_header_no'] = $this->lang->line('common_table_header_no');
        $string['table_header_substation'] = $this->lang->line('common_table_header_substation');
        $string['table_header_current'] = $this->lang->line('common_table_header_current');
        $string['table_header_voltage'] = $this->lang->line('common_table_header_voltage');
        $string['table_header_location'] = $this->lang->line('common_table_header_location');
        $string['auth_login'] = $this->lang->line('common_auth_common_login');

        $meta['retriever'] = site_url('api/find/');
        $meta['datatable_lang'] = base_url($this->lang->line('common_datatable_lang'));

        $data['meta']['i18n']['country'] = empty($data['meta']['i18n']['country'] = i18nGetCountryCode($this->country)) ? 'US' : $data['meta']['i18n']['country'];
        $data['meta']['i18n']['language'] = empty($data['meta']['i18n']['language'] = i18nGetLanguageCode($this->language)) ? 'en' : $data['meta']['i18n']['language'];
        $data['session']['flashdata'] = empty(@$this->session->userdata('flashdata')['message']) ? [] : $this->session->userdata('flashdata')['message'];

        $this->load->view('landing/index/landing_index_client_common_layout', compact('meta', 'string', 'data'));
    }
}

?>

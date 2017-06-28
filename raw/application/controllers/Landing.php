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
     * @var string $lang_prefix
     */
    private $language;
    private $lang_prefix;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('cookie');

        $this->language = (!empty(get_cookie('common_language')) ?: $this->config->item('language'));
    }

    public function index()
    {
        $this->load->helper('url');
        $this->lang_prefix = 'landing_index_client_common_layout_';

        $this->lang->load('layout/landing/index/landing_index_client_common_layout', $this->language);
        $this->lang->load('common/table/common_table_header', $this->language);
        $this->lang->load('common/auth/common_auth_common', $this->language);
        $this->lang->load('common', $this->language);

        $string = [];
        $meta = [];

        $string['title'] = $this->lang->line('common_title');
        $string['table_header_no'] = $this->lang->line('common_table_header_no');
        $string['table_header_substation'] = $this->lang->line('common_table_header_substation');
        $string['table_header_current'] = $this->lang->line('common_table_header_current');
        $string['table_header_voltage'] = $this->lang->line('common_table_header_voltage');
        $string['table_header_location'] = $this->lang->line('common_table_header_location');
        $string['auth_login'] = $this->lang->line('common_auth_common_login');

        $meta['retriever'] = site_url('api/find/');
        $meta['datatable_lang'] = base_url($this->lang->line('common_datatable_lang'));

        $this->load->view('landing/index/landing_index_client_common_layout', compact('meta', 'string'));
    }
}

?>

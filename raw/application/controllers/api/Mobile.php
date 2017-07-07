<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 07 July 2017, 1:58 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/MY_REST_Controller.php';

/**
 * Class Api
 * @property CI_Form_validation form_validation
 * @property CI_Lang lang
 * @property CI_Loader load
 * @property CI_Config config
 * @property CI_Security security
 * @property Ion_auth ion_auth
 * @property array data
 * @property CI_Input input
 * @property CI_Session session
 */
class Mobile extends \Restserver\Libraries\MY_REST_Controller
{
    /**
     * @var string
     */
    private $authGroup;
    /**
     * @var mixed|null|string
     */
    private $language;

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
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->database();
        /** @noinspection PhpParamsInspection */
        $this->load->library(['ion_auth']);
        $this->load->helper(['url']);

        $this->authGroup = 'member';

        $this->language = empty($this->language = get_cookie('common_language')) ? $this->config->item('language') : $this->language;
    }

    public function login_post()
    {
        /** @var array $response */
        $response = [];
        if (!empty($_SERVER['HTTP_X_ACCESS_PERMISSION']))
        {
            if (strcmp(strtolower($_SERVER['HTTP_X_ACCESS_PERMISSION']), $this->config->item('non_csrf_permission')) === 0)
            {
                if (strcmp(strtolower($this->postOrDefault('guard', null)), $this->config->item('non_csrf_guard')) === 0)
                {

                }
            }
        }
        $response['status'] = \Restserver\Libraries\REST_Controller::HTTP_OK;
        $this->response($response, $response['status']);
    }
}

?>

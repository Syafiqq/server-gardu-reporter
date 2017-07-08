<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 07 July 2017, 2:20 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/dao/DAOReport.php';
require_once APPPATH . '/model/ModelReport.php';
require_once APPPATH . '/model/ModelLocation.php';
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * @property MLocation mLocation
 * @property MReport mReport
 * @property CI_Input input
 */
class Default_route extends \Restserver\Libraries\REST_Controller
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

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function find_get()
    {
        $get = $this->get();
        if (!isset($get['id']))
        {
            $get['id'] = null;
        }

        $this->load->database();

        $this->load->model('mReport');
        $reports = [];

        /** @var DAOReport $report */
        foreach ($this->mReport->find($get['id']) as $report)
        {
            array_push($reports, $report->cSerialize());
        }

        $this->response([
            'status' => \Restserver\Libraries\REST_Controller::HTTP_OK,
            'data' => ['reports' => $reports]
        ], \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}

?>

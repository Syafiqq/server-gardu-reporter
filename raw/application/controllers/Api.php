<?php
/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 22 June 2017, 6:13 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/dao/DAOReport.php';
require_once APPPATH . '/model/ModelReport.php';
require_once APPPATH . '/model/ModelLocation.php';
require_once APPPATH . '/libraries/REST_Controller.php';

class Api extends \Restserver\Libraries\REST_Controller
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

    public function insert_post()
    {
        if ($this->input->is_ajax_request())
        {
            $post = $this->post();
            if (
                isset($post['substation']) &&
                isset($post['voltage']) &&
                isset($post['current']) &&
                isset($post['location']) &&
                isset($post['location']['latitude']) &&
                isset($post['location']['longitude'])
            )
            {
                $this->load->database();

                $report = new DAOReport(null, null, new ModelReport($post['substation'], $post['voltage'], $post['current'], new ModelLocation($post['location']['latitude'], $post['location']['longitude'])));

                $this->load->model('mLocation');
                $this->load->model('mReport');
                $this->mReport->insert($report, $this->mLocation);

                $this->response([
                    'code' => \Restserver\Libraries\REST_Controller::HTTP_OK,
                    'data' => ['message' => 'Data Successfully Retrieved']
                ], \Restserver\Libraries\REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response([
                    'code' => \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED,
                    'data' => ['message' => 'Insufficient Data']
                ], \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
        else
        {
            $this->response([
                'code' => \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST,
                'data' => ['message' => 'Bad Request']
            ], \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
        }
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
            'code' => \Restserver\Libraries\REST_Controller::HTTP_OK,
            'data' => ['reports' => $reports]
        ], \Restserver\Libraries\REST_Controller::HTTP_OK);
    }
}

?>

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH."/reports/CorpDriver.php";

class CorpDriverReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        ////////////DEFAULT LOAD BELOW FUNCTIONLITY WHEN CALL V1 CONTROLLER
        /////// LOAD LIBRARY VALIDATION CLASS
        $this->load->library('validation');
        $report = new CorpDriver();
        $report->run()->render();
        ///// LOAD MODEL CLASS
        $this->load->model('m_site');
        ////// RESONSE HEADER CONTEN TYPRE SET FROM DEFAULT(TEXT/HTML) TO APPLICATION/JSON
    }

    function index() {
        //// DEFAULT SITE CONTROLLER METHOD CALL
//        $data['business_list'] = $this->m_site->get_business_list();
//        $this->load->view('v_corpDriverReport');
    }
}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rating extends CI_Controller {

    public function __construct() {
        parent::__construct();
        ////////////DEFAULT LOAD BELOW FUNCTIONLITY WHEN CALL V1 CONTROLLER
        /////// LOAD LIBRARY VALIDATION CLASS
        $this->load->library('validation');
        ///// LOAD MODEL CLASS
        $this->load->model('m_site');
        ////// RESONSE HEADER CONTEN TYPRE SET FROM DEFAULT(TEXT/HTML) TO APPLICATION/JSON
    }

    function index() {
        
    }

    function business_rating() {
        $param = $_REQUEST;
        $this->m_site->business_rating($param);
        $this->load->view('v_rating');
    }

    function product_rating() {
        $param = $_REQUEST;
        
        $this->m_site->product_rating($param);
        $this->load->view('v_product_rating');
    }

}

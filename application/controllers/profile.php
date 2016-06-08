<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

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
        is_login() ? '' : redirect('index.php/login');
        $businessID = is_login();
        $data = $this->m_site->get_business($businessID);
        $this->load->view('v_profile', $data);
    }

    function edit_profile() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->validation->is_parameter_blank('address', $param['address']);
        $this->validation->is_parameter_blank('email', $param['email']);
        $this->validation->is_parameter_blank('website', $param['website']);
        $this->validation->is_parameter_blank('phone', $param['phone']);
        $this->validation->is_parameter_blank('businessTypes', $param['businessTypes']);
        $this->validation->is_parameter_blank('marketing_statement', $param['marketing_statement']);
        $this->validation->is_parameter_blank('short_name', $param['short_name']);
        $this->validation->is_parameter_blank('sms_no', $param['sms_no']);  
        $data = $this->m_site->update_business_profile($param);
        echo json_encode($data);
    }

}

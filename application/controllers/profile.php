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
    
    function edit_stripe_secret_key()
    {
        is_login() ? '' : redirect('index.php/login');
        $param=$_REQUEST;
        
        $param['businessID'] = is_login();
        $data = $this->m_site->update_business_stripe_secret_key($param);
        echo json_encode($data);
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

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
        $this->session->unset_userdata('businessID');
        is_login() ? redirect('index.php/site/orderlist') : '';
        $param = $_REQUEST;

        $data['business'] = $this->m_site->get_business(decrypt_string($param['businessID']));
//   
        $this->load->view('v_login', $data);
    }

    function do_login() {

        $param = $_POST;

        $this->validation->is_parameter_blank('username', $param['username']);
        $this->validation->is_parameter_blank('password', $param['password']);
        $reponse = $this->m_site->do_login($param);
        if ($reponse['status'] == 1) {
            redirect('index.php/site/orderlist');
        } else {
            redirect($param['business_url']);
        }
    }

    function logout() {
        !is_login() ? redirect("/") : '';
        $this->session->set_flashdata('success1', 'Successfully logged out.');
        $this->session->unset_userdata('businessID');
        $businessUrl = $this->session->userdata('business_url');
        if ($businessUrl != '') {
            $this->session->unset_userdata('business_url');
            redirect($businessUrl);
        } else {
            redirect('index.php/login');
        }
        
        
    }

}

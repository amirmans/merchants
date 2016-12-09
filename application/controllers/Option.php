<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Option extends CI_Controller {

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
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['options'] = $this->m_site->get_business_options($param);
        $this->load->view('v_option', $data);
    }

    function add() {
        is_login() ? '' : redirect('index.php/login');
        $param['businessID'] = is_login();
        $data['product_option_category'] = $this->m_site->get_products_option_category($param);
        $this->load->view('v_option_add', $data);
    }

    function insert_option() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->validation->is_parameter_blank('name', $param['name']);
        $this->validation->is_parameter_blank('price', $param['price']);
        $this->validation->is_parameter_blank('product_option_category_id', $param['product_option_category_id']);
        $param['description'] = $this->validation->set_blank_parameter($param['description']);

        $data = $this->m_site->insert_option($param);
        echo json_encode($data);
    }

    function edit($optionId) {
        is_login() ? '' : redirect('index.php/login');
        $param['businessID'] = is_login();
        $data['product_option_category'] = $this->m_site->get_products_option_category($param);
        $data['option'] = $this->m_site->get_products_option($optionId);
        $this->load->view('v_option_edit', $data);
    }

    function edit_option() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();

        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->validation->is_parameter_blank('option_id', $param['option_id']);
        $this->validation->is_parameter_blank('name', $param['name']);
        $this->validation->is_parameter_blank('price', $param['price']);
        $this->validation->is_parameter_blank('product_option_category_id', $param['product_option_category_id']);
        $param['description'] = $this->validation->set_blank_parameter($param['description']);
        $this->m_site->edit_option($param);
        redirect('index.php/option');
      
    }

  function set_availailblity_status() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;

        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->m_site->set_option_availailblity_status($param);
        $response = success_res("Successfully Set Availailblity Status");
        echo json_encode($response);
    }
    
    function delete($option_id) {
        is_login() ? '' : redirect('index.php/login');
        $data = $this->m_site->delete_option($option_id);
        redirect('index.php/option');
    }

}

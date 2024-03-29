<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends CI_Controller {

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
        $data['products'] = $this->m_site->get_business_products($param);
        $this->load->view('v_product', $data);
    }

    function add() {
        is_login() ? '' : redirect('index.php/login');
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['product_category'] = $this->m_site->get_business_product_category($param);

        $this->load->view('v_product_add', $data);
    }

//    function add_options($product_id = 0) {
//        is_login() ? '' : redirect('index.php/login');
//        $param['businessID'] = is_login();
//        $data['product_option_category'] = $this->m_site->get_products_option_category();
//        $data['product_id'] = $product_id;
//        $this->load->view('v_product_option_add', $data);
//    }

    function add_category() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['product_category'] = $this->m_site->add_product_category($param);
        echo json_encode($data);
    }

    function update_category() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['product_category'] = $this->m_site->update_product_category($param);
        echo json_encode($data);
    }

    function delete_category() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['product_category'] = $this->m_site->delete_product_category($param);
        echo json_encode($data);
    }

    function add_option_category() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('option_category_name', $param['option_category_name']);
        $data['product_option_category'] = $this->m_site->add_product_option_category($param);
        echo json_encode($data);
    }

    function edit_option_category() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('edit_option_category_name', $param['edit_option_category_name']);
        $data['product_option_category'] = $this->m_site->edit_product_option_category($param);
        echo json_encode($data);
    }

    function delete_option_category() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['option_category'] = $this->m_site->delete_product_option_category($param);
        echo json_encode($data);
    }

    function insert() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;


        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->validation->is_parameter_blank('name', $param['name']);
        $this->validation->is_parameter_blank('price', $param['price']);
        $this->validation->is_parameter_blank('product_category_id', $param['product_category_id']);
        $param['SKU'] = $this->validation->set_blank_parameter($param['SKU']);
        $param['short_description'] = $this->validation->set_blank_parameter($param['short_description']);
        $param['long_description'] = $this->validation->set_blank_parameter($param['long_description']);
        $param['price'] = $this->validation->set_blank_parameter($param['price']);
        $param['detail_information'] = $this->validation->set_blank_parameter($param['detail_information']);
        $param['runtime_fields'] = $this->validation->set_blank_parameter($param['runtime_fields']);
        $param['runtime_fields_detail'] = $this->validation->set_blank_parameter($param['runtime_fields_detail']);
        $param['sales_price'] = $this->validation->set_blank_parameter($param['sales_price']);
        $param['has_option'] = $this->validation->set_blank_parameter($param['has_option']);
        $param['bought_with_rewards'] = $this->validation->set_blank_parameter($param['bought_with_rewards']);
        $param['more_information'] = $this->validation->set_blank_parameter($param['more_information']);
        if (!file_exists('../' . staging_directory() . '/customer_files/' . $param['businessID'])) {
            mkdir('../' . staging_directory() . '/customer_files/' . $param['businessID'], 0777, true);
        }
        if (!file_exists('../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products')) {
            mkdir('../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products', 0777, true);
        }
        if ($_FILES['pictures']["name"] != "") {
            // $temp = explode(".", $_FILES['pictures']["name"]);
            // $extension = end($temp);

            if (move_uploaded_file($_FILES['pictures']['tmp_name'], '../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products/' . '' . $_FILES['pictures']["name"])) {
                $param['pictures'] = $_FILES['pictures']["name"];
            } else {
                $param['pictures'] = "";
            }
        }else{
              $param['pictures'] = "";
        }
        // $param['pictures'] = $this->validation->file_upload("pictures", '../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products');

        $data = $this->m_site->insert_product($param);
        echo json_encode($data);
    }

//    function insert_option() {
//        is_login() ? '' : redirect('index.php/login');
//        $param = $_REQUEST;
//        $param['businessID'] = is_login();
//        $this->validation->is_parameter_blank('businessID', $param['businessID']);
//        $this->validation->is_parameter_blank('name', $param['name']);
//        $this->validation->is_parameter_blank('price', $param['price']);
//        $this->validation->is_parameter_blank('product_id', $param['product_id']);
//        $this->validation->is_parameter_blank('product_option_category_id', $param['product_option_category_id']);
//        $param['description'] = $this->validation->set_blank_parameter($param['description']);
//
//        $data = $this->m_site->insert_product_option($param);
//        echo json_encode($data);
//    }

    function insert_product_options() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->validation->is_parameter_blank('product_id', $param['product_id']);

        $data = $this->m_site->insert_options($param);
        echo json_encode($data);
    }

    function options($product_id = 0) {
        is_login() ? '' : redirect('index.php/login');
        $param['product_id'] = $product_id;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['options'] = $this->m_site->get_products_options($param);
        $data['product_id'] = $product_id;
        $productInfo = $this->m_site->get_product_info($product_id);
        $data['product_name'] = $productInfo['name'];
        $this->load->view('v_product_options', $data);
    }

    function set_availailblity_status() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;

        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->m_site->set_product_availailblity_status($param);
        $response = success_res("Successfully Set Availailblity Status");
        echo json_encode($response);
    }
 function set_product_order()
    {
        $param=$_REQUEST;
        $data = $this->m_site->set_product_order($param);
        echo json_encode($data);
    }

    function edit($product_id) {
        is_login() ? '' : redirect('index.php/login');
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $data['product'] = $this->m_site->get_product_info($product_id);
        $data['product_category'] = $this->m_site->get_business_product_category($param);

        $this->load->view('v_product_edit', $data);
    }

    function update() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;

      
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $this->validation->is_parameter_blank('name', $param['name']);
        $this->validation->is_parameter_blank('price', $param['price']);
        $this->validation->is_parameter_blank('product_category_id', $param['product_category_id']);
        $param['SKU'] = $this->validation->set_blank_parameter($param['SKU']);
        $param['short_description'] = $this->validation->set_blank_parameter($param['short_description']);
        $param['long_description'] = $this->validation->set_blank_parameter($param['long_description']);
        $param['price'] = $this->validation->set_blank_parameter($param['price']);
        $param['detail_information'] = $this->validation->set_blank_parameter($param['detail_information']);
        $param['runtime_fields'] = $this->validation->set_blank_parameter($param['runtime_fields']);
        $param['runtime_fields_detail'] = $this->validation->set_blank_parameter($param['runtime_fields_detail']);
        $param['sales_price'] = $this->validation->set_blank_parameter($param['sales_price']);
        $param['has_option'] = $this->validation->set_blank_parameter($param['has_option']);
        $param['bought_with_rewards'] = $this->validation->set_blank_parameter($param['bought_with_rewards']);
        $param['more_information'] = $this->validation->set_blank_parameter($param['more_information']);
        if (!file_exists('../' . staging_directory() . '/customer_files/' . $param['businessID'])) {
            mkdir('../' . staging_directory() . '/customer_files/' . $param['businessID'], 0777, true);
        }
        if (!file_exists('../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products')) {
            mkdir('../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products', 0777, true);
        }


        if ($_FILES['pictures']["name"] != "") {
            // $temp = explode(".", $_FILES['pictures']["name"]);
            // $extension = end($temp);

            if (move_uploaded_file($_FILES['pictures']['tmp_name'], '../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products/' . '' . $_FILES['pictures']["name"])) {
                $param['pictures'] = $_FILES['pictures']["name"];
            } else {
                $param['pictures'] = "";
            }
        }else{
              $param['pictures'] = "";
        }

        //$param['pictures'] = $this->validation->file_upload("pictures", '../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products');
//        if ($param['pictures'] != '') {
//            $oldfilepath = '../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products/' . $param['old_pictures'];
//            if (file_exists($oldfilepath)) {
//                unlink($oldfilepath);
//            }
//        }
//        if ($param['is_picture_deleted'] == '1') {
//            $oldfilepath = '../' . staging_directory() . '/customer_files/' . $param['businessID'] . '/products/' . $param['old_pictures'];
//            if (file_exists($oldfilepath)) {
//                unlink($oldfilepath);
//            }
//        }
//        if ($param['is_picture_deleted'] == '0' && $param['pictures'] == '') {
//            $param['pictures'] = $param['old_pictures'];
//        }
        $data = $this->m_site->update_product($param);
        redirect('index.php/product');
    }

    function delete($product_id) {
        is_login() ? '' : redirect('index.php/login');
        $data = $this->m_site->delete_product($product_id);
        redirect('index.php/product');
    }

}

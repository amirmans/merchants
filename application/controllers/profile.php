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
//        $this->validation->is_parameter_blank('email', $param['email']);
//        $this->validation->is_parameter_blank('website', $param['website']);
//        $this->validation->is_parameter_blank('phone', $param['phone']);
        //$this->validation->is_parameter_blank('businessTypes', $param['businessTypes']);
//        $this->validation->is_parameter_blank('marketing_statement', $param['marketing_statement']);
        $this->validation->is_parameter_blank('short_name', $param['short_name']);
//        $this->validation->is_parameter_blank('sms_no', $param['sms_no']);
        //        $this->validation->is_parameter_blank('process_time', $param['process_time']);

        if ($_FILES['image_upload_file']['tmp_name'] != "") {
            $image_url = $this->m_site->file_upload("image_upload_file", '../' . staging_directory() . '/customer_files/icons');
            $param['icon'] = $image_url;
        } else {
            $param['icon'] = "";
        }


        $data = $this->m_site->update_business_profile($param);


        echo json_encode($data);
    }

    function edit_opening_hours() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $data = $this->m_site->update_business_opening_hours($param);

        echo json_encode($data);
    }

        function edit_internal_info() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $data = $this->m_site->edit_internal_info($param);
        echo json_encode($data);
    }

    function edit_stripe_key() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('stripe_secret_key', $param['stripe_secret_key']);
        $data = $this->m_site->edit_stripe_key($param);

        echo json_encode($data);
    }

    function do_authenticate() {
        $param = $_POST;
        $param['businessID'] = is_login();
        $this->validation->is_parameter_blank('username', $param['username']);
        $this->validation->is_parameter_blank('password', $param['password']);
        $this->validation->is_parameter_blank('businessID', $param['businessID']);
        $reponse = $this->m_site->do_authenticate($param);
        echo json_encode($reponse);
    }

    function add_business_images() {
        is_login() ? '' : redirect('index.php/login');
        $param = $_REQUEST;
        $businessID = is_login();
        $business = $this->m_site->get_business($businessID);
        $pictures = explode(",", $business["business_detail"]["pictures"]);
        foreach ($pictures as &$p) {
//            $p='../../../' . staging_directory() . '/customer_files/'.$businessID.'/'.trim($p);
            $p = trim($p);
        }
        $data["picutres"] = $pictures;

        $this->load->view('v_add_business_images', $data);
    }

    function insert_business_image() {
        $businessID = is_login();
        if (!file_exists('../' . staging_directory() . '/customer_files/' . $businessID)) {
            mkdir('../' . staging_directory() . '/customer_files/' . $businessID, 0777, true);
        }

        $param["businessId"] = $businessID;
        $param["picture"] = $this->m_site->file_upload("picture", '../' . staging_directory() . '/customer_files/' . $businessID);
        $data = $this->m_site->insert_business_image($param);

        echo json_encode($data);
    }

    function delete_business_image($file_name) {

        $businessID = is_login();
        if (file_exists('../' . staging_directory() . '/customer_files/' . $businessID . "/" . $file_name)) {
            unlink('../' . staging_directory() . '/customer_files/' . $businessID . "/" . $file_name);
        }
        $param["businessId"] = $businessID;
        $param["picture"] = $file_name;
        $data = $this->m_site->delete_business_image($param);
        echo json_encode($data);
    }

    function replace_business_image() {

        $businessID = is_login();
        $param = $_REQUEST;
        if (file_exists('../' . staging_directory() . '/customer_files/' . $businessID . "/" . $param["file_name"])) {
            unlink('../' . staging_directory() . '/customer_files/' . $businessID . "/" . $param["file_name"]);
        }
        $picture = $this->move_to_upload($param["file_name"], "picture1", '../' . staging_directory() . '/customer_files/' . $businessID);

        $data = success_res("Business Image replace successfully");
        echo json_encode($data);
    }

    function move_to_upload($file_name, $file_key, $folder_path) {
//////////////////// MOVE TO UPLOAD FILE TO FOLDER
        //////////////$file_key=KEY NAME OF $_FILE
        //////////////$folder_path=PATH OF DESITINAMTION FOLDER

        if ($_FILES[$file_key]["name"] !== "") {
            $temp = explode(".", $_FILES[$file_key]["name"]);
            $extension = end($temp);

            $file_path = $folder_path . "/" . $file_name;
            if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $file_path)) {
                return $file_name;
            } else {
                return "";
            }
        } else {

            return "";
        }
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class DBTransfer extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        ////////////DEFAULT LOAD BELOW FUNCTIONLITY WHEN CALL V1 CONTROLLER
        /////// LOAD LIBRARY VALIDATION CLASSa
        $this->load->library('validation');
        ///// LOAD MODEL CLASS
        $this->load->model('M_transfer');
        ////// RESONSE HEADER CONTEN TYPRE SET FROM DEFAULT(TEXT/HTML) TO APPLICATION/JSON
    }
    
    function index() {
        ///// DEFULT DB_transfer CONTROLLER MEHOD CALL
    }
    
    function mask() {
        $success = $this->M_transfer->maskInfo();
        if (!$success) {
            print("Something went wrong....");
        }

    }
}

//////////// HERE DO NOT END PHP TAG
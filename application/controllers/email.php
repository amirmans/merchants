<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends CI_Controller {

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
///// DEFULT SITE CONTROLLER MEHOD CALL
    }

    function email_configration() {
        $email = "tap-in@tapforall.com";
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.artdoost.com';
        $config['smtp_port'] = '26';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = $email;
        $config['smtp_pass'] = 'b#Fq0w<ZAM#u<&';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not
        $this->email->initialize($config);
        $this->email->from($email, 'Tap-in');
    }

    function send_mail_new_order($data, $email) {
        $this->email_configration();
        $body = $this->load->view('v_email_new_order', $data, TRUE);
        $subject = "New order from Tap-In";
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->send();
//        echo $this->email->print_debugger();
    }

    function send_neworder_email() {

        $param = $_REQUEST;

        $order_id = $param['order_id'];
        $business_id = $param['business_id'];

        $business = $this->m_site->get_business($business_id);
        $business = $business["business_detail"];

        $order_payment_detail = $this->m_site->get_order_payment_detail($order_id);
        $order_info = $this->m_site->get_ordelist_order($order_id, $business_id);
        $email['order_detail'] = $this->m_site->get_order_detail($order_id);
        $email['order_id'] = $order_id;
        $email['total'] = $order_payment_detail['total'];
        $email['subtotal'] = $order_info[0]['subtotal'];
        $email['tip_amount'] = $order_info[0]['tip_amount'];
        $email['tax_amount'] = $order_info[0]['tax_amount'];
        $email['business_id'] = $business_id;
        $email['business_name'] = $business["name"];

         if($business["email"]!="")
        {
             $this->send_mail_new_order($email,$business["email"]);
        }
    }


}

//////////// HERE DO NOT END PHP TAG

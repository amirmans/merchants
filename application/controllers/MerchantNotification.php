<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MerchantNotification extends CI_Controller {

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
        // $config['smtp_pass'] = 'b#Fq0w<ZAM#u<&';
        $config['smtp_pass'] = 'TigM0m!!';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not
        $this->email->initialize($config);
        $this->email->from($email, 'Tap-in');
    }

    function send_mail_for_new_order($data, $email) {
        $this->email_configration();
        $body = $this->load->view('v_email_new_order', $data, TRUE);

        $subject = "New order from Tap-In";
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($body);
        $result = $this->email->send();
//        echo $this->email->print_debugger();
        if ($result != true) {
            log_message('error', "Email to $email could not be sent!");
        }
    }

    function notify_business_for_new_order() {
//
        $param = $_REQUEST;

        $order_id = $param['order_id'];
        $business_id = $param['business_id'];
        $business_email = "";
        $sms_numbers = "";

        $business_internal_alerts = $this->m_site->get_business_internal_alerts($business_id);
        if (!empty($business_internal_alerts)) {
            $business_email = $business_internal_alerts[0]["email"];
            $sms_numbers = $business_internal_alerts[0]["sms_no"];
        }

//        $business = $this->m_site->get_business($business_id);
//        $business = $business["business_detail"];
        if ($business_email != "") {
            $order_payment_detail = $this->m_site->get_order_payment_detail($order_id);
            $order_info = $this->m_site->get_ordelist_order($order_id, $business_id,"");//TODO
            $email['order_detail'] = $this->m_site->get_order_detail($order_id);
            $email['order_id'] = $order_id;
            $email['total'] = $order_payment_detail['total'];
            $email['subtotal'] = $order_info[0]['subtotal'];
            $email['tip_amount'] = $order_info[0]['tip_amount'];
            $email['tax_amount'] = $order_info[0]['tax_amount'];
            $email['points_dollar_amount'] = $order_info[0]['points_dollar_amount'];
            $email['business_id'] = $business_id;
            $email['delivery_charge_amount'] = $order_info[0]['delivery_charge_amount'];
            $email['promotion_code'] = $order_info[0]['promotion_code'];
            $email['promotion_discount_amount'] = $order_info[0]['promotion_discount_amount'];
            $email['delivery_instruction'] = $order_info[0]['delivery_instruction'];
            $email['delivery_address'] = $order_info[0]['delivery_address'];
            $email['delivery_time'] = $order_info[0]['delivery_time'];
            $email['consumer_delivery_id'] = $order_info[0]['consumer_delivery_id'];

            $this->send_mail_for_new_order($email, $business_email);
        }

        // if sms fails, twilio exits the app, That is why we want call this at the end after sending the email
        if (!empty($sms_numbers)) {
            $sms_numbers = preg_replace('/\s/', '', $sms_numbers);
            $sms_numbers_array = explode(',', $sms_numbers);
            foreach ($sms_numbers_array as $sms_no) {
                $this->m_site->smsMerchant("There is a new order!", $sms_no, $business_id);
            }
        }

    }



}

//////////// HERE DO NOT END PHP TAG
